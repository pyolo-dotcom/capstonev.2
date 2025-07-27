<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FlespiData;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class FlespiFetchController extends Controller
{
    public function fetchAndStore(Request $request)
    {
        set_time_limit(300); // 5 minutes timeout
        
        Log::info('Flespi fetch initiated via HTTP request');
        
        $deviceId = env('FLESPI_DEVICE_ID');
        $token = env('FLESPI_TOKEN');
        
        if (empty($token) || empty($deviceId)) {
            $error = 'Missing Flespi configuration in .env';
            Log::error($error);
            return response()->json(['error' => $error], 500);
        }
    
        try {
            if ($request->has('use_artisan')) {
                Artisan::call('flespi:fetch');
                return response()->json([
                    'success' => true,
                    'message' => 'Processing started via Artisan'
                ]);
            }
            
            $count = $request->input('count', 100); // Get count from request or default to 100
            $result = $this->fetchNewData($deviceId, $token, $count);
            
            return response()->json([
                'success' => true,
                'fetched' => $result['total'],
                'stored' => $result['stored']
            ]);
            
        } catch (\Exception $e) {
            Log::error("HTTP Flespi fetch failed: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchNewData(string $deviceId, string $token, int $count = 100): array
    {
        // Get the latest timestamp we have in database
        $lastStoredMessage = FlespiData::where('device_id', $deviceId)
            ->orderBy('timestamp', 'desc')
            ->first();

        $params = [
            'limit' => $count, // Use the provided count parameter
            'sort' => '-id'
        ];

        if ($lastStoredMessage) {
            $lastTimestamp = Carbon::parse($lastStoredMessage->timestamp)->timestamp;
            $params['filter'] = 'timestamp > '.$lastTimestamp;
            Log::info('Fetching messages newer than timestamp: '.$lastTimestamp);
        } else {
            Log::info('No previous messages found, fetching latest messages');
        }

        $response = Http::retry(3, 1000)
            ->timeout(120)
            ->withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
                'Accept' => 'application/json',
            ])
            ->get("https://flespi.io/gw/devices/{$deviceId}/messages", $params);

        if (!$response->successful()) {
            throw new \Exception($response->json()['errors'][0]['reason'] ?? $response->body());
        }

        $messages = $response->json('result');
        $storedCount = $this->processMessages($messages, $deviceId);
        
        return [
            'total' => count($messages),
            'stored' => $storedCount
        ];
    }

    protected function processMessages(array $messages, string $deviceId): int
    {
        $count = 0;
        $batchInsert = [];
        $now = now();
        
        foreach ($messages as $message) {
            try {
                $latitude = $this->extractLatitude($message);
                $longitude = $this->extractLongitude($message);
                $timestamp = $this->extractTimestamp($message);

                if (!$latitude || !$longitude || !$timestamp) {
                    Log::debug('Skipping message - missing required fields');
                    continue;
                }

                $messageTime = Carbon::createFromTimestamp($timestamp);
                $formattedTimestamp = $messageTime->format('Y-m-d H:i:s');

                $exists = FlespiData::where('device_id', $deviceId)
                    ->whereBetween('timestamp', [
                        $messageTime->copy()->subMinutes(2),
                        $messageTime->copy()->addMinutes(2)
                    ])
                    ->whereBetween('latitude', [$latitude - 0.001, $latitude + 0.001])
                    ->whereBetween('longitude', [$longitude - 0.001, $longitude + 0.001])
                    ->exists();

                if (!$exists) {
                    $batchInsert[] = [
                        'device_id' => $deviceId,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'timestamp' => $formattedTimestamp,
                        'payload' => json_encode($message, JSON_UNESCAPED_SLASHES),
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                    $count++;
                }

                if (count($batchInsert) >= 50) {
                    FlespiData::insert($batchInsert);
                    $batchInsert = [];
                }
                
            } catch (\Exception $e) {
                Log::error('Error processing message', [
                    'error' => $e->getMessage(),
                    'message' => $message['id'] ?? null
                ]);
                continue;
            }
        }
        
        if (!empty($batchInsert)) {
            FlespiData::insert($batchInsert);
        }
        
        return $count;
    }
    
    protected function callArtisanAsync(string $command, array $options = [])
    {
        try {
            // Use Symfony Process to run in background
            $artisanPath = base_path('artisan');
            $commandString = "php {$artisanPath} {$command} " . $this->buildOptionsString($options);
            
            // For Windows:
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                pclose(popen("start /B {$commandString}", "r"));
            } 
            // For Linux/Unix:
            else {
                exec("nohup {$commandString} > /dev/null 2>&1 &");
            }
            
        } catch (\Exception $e) {
            Log::error("Artisan command failed: {$command}", [
                'error' => $e->getMessage(),
                'options' => $options
            ]);
        }
    }
    
    protected function buildOptionsString(array $options): string
    {
        return collect($options)
            ->map(function ($value, $key) {
                return "--{$key}=\"{$value}\"";
            })
            ->implode(' ');
    }


    protected function extractLatitude(array $message): ?float
    {
        return $message['position.lat'] ?? 
               $message['position.latitude'] ?? 
               $message['position']['lat'] ?? 
               $message['position']['latitude'] ?? 
               $message['lat'] ?? 
               $message['latitude'] ?? null;
    }

    protected function extractLongitude(array $message): ?float
    {
        return $message['position.lng'] ?? 
               $message['position.longitude'] ?? 
               $message['position']['lng'] ?? 
               $message['position']['longitude'] ?? 
               $message['lng'] ?? 
               $message['lon'] ?? 
               $message['longitude'] ?? null;
    }

    protected function extractTimestamp(array $message): ?float
    {
        $timestamp = $message['timestamp'] ?? $message['time'] ?? null;
        
        if (is_null($timestamp)) {
            return null;
        }
        
        if ($timestamp > 9999999999) {
            $timestamp = $timestamp > 1e15 ? $timestamp / 1e6 : $timestamp / 1000;
        }
        
        return $timestamp;
    }
}
