<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\FlespiData;
use Illuminate\Support\Facades\Log;

class FetchFlespiData extends Command
{
    protected $signature = 'flespi:fetch';
    protected $description = 'Fetch data from Flespi API and store in MySQL';

    public function handle()
    {
        $this->info("Starting Flespi data fetch...");
        
        $deviceId = env('FLESPI_DEVICE_ID');
        $token = env('FLESPI_TOKEN');
        
        if (empty($token) || empty($deviceId)) {
            $this->error('Missing Flespi configuration in .env');
            return;
        }
    
        try {
            $response = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token
            ])->get("https://flespi.io/gw/devices/{$deviceId}/messages", [
                'limit' => 50,
                'sort' => '-id'
            ]);
    
            if (!$response->successful()) {
                $error = $response->json()['errors'][0]['reason'] ?? $response->body();
                throw new \Exception($error);
            }
    
            $messages = $response->json('result');
            
            if (empty($messages)) {
                $this->info('No messages found for device.');
                return;
            }
    
            $count = 0;
            foreach ($messages as $message) {
                // Try multiple possible field names for each value
                $latitude = $message['position.lat'] ?? 
                           $message['position.latitude'] ?? 
                           $message['position']['lat'] ?? 
                           $message['position']['latitude'] ?? null;
                
                $longitude = $message['position.lng'] ?? 
                             $message['position.longitude'] ?? 
                             $message['position']['lng'] ?? 
                             $message['position']['longitude'] ?? null;
                
                $timestamp = $message['timestamp'] ?? $message['time'] ?? null;
    
                if (!$latitude || !$longitude || !$timestamp) {
                    continue;
                }
    
                // Skip if already exists
                if (!FlespiData::where('device_id', $deviceId)
                             ->where('timestamp', date('Y-m-d H:i:s', $timestamp))
                             ->exists()) {
                    FlespiData::create([
                        'device_id' => $deviceId,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'timestamp' => date('Y-m-d H:i:s', $timestamp),
                        'payload' => json_encode($message)
                    ]);
                    $count++;
                }
            }
    
            $this->info("Successfully stored {$count} new messages.");
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}