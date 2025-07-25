<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
// Add this to the top of your controller methods
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

class FlespiController extends Controller
{
    // Device constants
    const FLESPI_DEVICE_ID = 6472131; // TKSTAR TK905B device ID
    const FLESPI_CHANNEL_ID = 1265317; // Channel ID
    const FLESPI_API_URL = 'https://flespi.io/gw/devices';
    const FLESPI_WS_URL = 'wss://mqtt.flespi.io:443/ws';
    const COMMAND_TIMEOUT = 30; // Timeout for commands in seconds

    /**
     * Get the latest device location
     */
    public function getDeviceLocation($deviceId)
    {
        $token = $this->validateToken();
        if (!$token) {
            return response()->json(['error' => 'Invalid Flespi token configuration'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
                'Accept' => 'application/json',
            ])
            ->timeout(10)
            ->retry(3, 1000)
            ->get("https://flespi.io/gw/devices/{$deviceId}/messages", [
                'fields' => 'position.latitude,position.longitude,position.speed,position.altitude,battery.level,timestamp,device_id',
                'limit' => 1,
                'sort' => '-id'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'result' => $data['result'] ?? [],
                    'status' => 'success'
                ]);
            }

            return response()->json([
                'error' => $response->json()['error'] ?? 'Unknown error',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error("Flespi location error: " . $e->getMessage());
            return response()->json([
                'error' => 'Service temporarily unavailable',
                'status' => 503
            ], 503);
        }
    }

    /**
     * Get device information with more detailed data
     */
    public function getDeviceInfo($deviceId)
    {
        $token = $this->validateToken();
        if (!$token) {
            return $this->errorResponse('Invalid Flespi token configuration', 401);
        }

        if ($deviceId != self::FLESPI_DEVICE_ID) {
            return $this->errorResponse('Invalid device ID', 400);
        }

        try {
            // Get device details
            $deviceResponse = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
            ])
            ->timeout(5)
            ->get(self::FLESPI_API_URL.'/'.$deviceId);

            if (!$deviceResponse->successful()) {
                return $this->handleFlespiError($deviceResponse);
            }

            $deviceData = $deviceResponse->json();
            
            // Get channel details
            $channelResponse = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
            ])
            ->timeout(5)
            ->get('https://flespi.io/gw/channels/'.self::FLESPI_CHANNEL_ID);

            $channelData = $channelResponse->successful() ? $channelResponse->json() : null;

            return response()->json($this->formatDeviceInfo($deviceData, $channelData));

        } catch (\Exception $e) {
            Log::error("Flespi device info error - Device: {$deviceId}: " . $e->getMessage());
            return $this->errorResponse('Service temporarily unavailable', 503);
        }
    }

    /**
     * Get device messages history
     */
    public function getDeviceHistory($deviceId, Request $request)
    {
        $token = $this->validateToken();
        if (!$token) {
            return $this->errorResponse('Invalid Flespi token configuration', 401);
        }

        $validated = $request->validate([
            'from' => 'sometimes|date',
            'to' => 'sometimes|date',
            'limit' => 'sometimes|integer|max:1000',
            'fields' => 'sometimes|string'
        ]);

        try {
            $params = [
                'fields' => $validated['fields'] ?? 'position.latitude,position.longitude,position.speed,position.altitude,battery.level,timestamp',
                'limit' => $validated['limit'] ?? 100,
                'sort' => '-id'
            ];

            if (!empty($validated['from'])) {
                $params['filter'] = 'timestamp > '.strtotime($validated['from']);
            }

            if (!empty($validated['to'])) {
                $params['filter'] = (isset($params['filter']) ? $params['filter'].' and ' : '') . 
                                    'timestamp < '.strtotime($validated['to']);
            }

            $response = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
            ])
            ->timeout(15)
            ->get(self::FLESPI_API_URL.'/'.$deviceId.'/messages', $params);

            if ($response->successful()) {
                return response()->json([
                    'result' => array_map([$this, 'formatDeviceData'], $response->json()['result'] ?? []),
                    'status' => 'success'
                ]);
            }

            return $this->handleFlespiError($response);

        } catch (\Exception $e) {
            Log::error("Flespi history error - Device: {$deviceId}: " . $e->getMessage());
            return $this->errorResponse('Service temporarily unavailable', 503);
        }
    }

    /**
     * Send command to device
     */
    public function sendCommandToDevice($deviceId, Request $request)
    {
        $token = $this->validateToken();
        if (!$token) {
            return $this->errorResponse('Invalid Flespi token configuration', 401);
        }

        $validated = $request->validate([
            'command' => 'required|string|in:reboot,get_position,set_update_interval',
            'parameters' => 'sometimes|array',
            'parameters.interval' => 'sometimes|integer|min:10|max:3600'
        ]);

        try {
            $commandData = [
                'name' => $validated['command'],
                'parameters' => $validated['parameters'] ?? []
            ];

            $response = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
            ])
            ->timeout(self::COMMAND_TIMEOUT)
            ->post(self::FLESPI_API_URL.'/'.$deviceId.'/commands', $commandData);

            if ($response->successful()) {
                $commandId = $response->json()['result']['id'] ?? null;
                Log::info("Command sent to device {$deviceId}: {$validated['command']}, ID: {$commandId}");
                
                return response()->json([
                    'success' => true,
                    'command_id' => $commandId,
                    'message' => 'Command sent successfully'
                ]);
            }

            return $this->handleFlespiError($response);

        } catch (\Exception $e) {
            Log::error("Flespi command error - Device: {$deviceId}, Command: {$validated['command']}: " . $e->getMessage());
            return $this->errorResponse('Failed to send command', 500);
        }
    }

    /**
     * Get command result
     */
    public function getCommandResult($deviceId, $commandId)
    {
        $token = $this->validateToken();
        if (!$token) {
            return $this->errorResponse('Invalid Flespi token configuration', 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token,
            ])
            ->timeout(10)
            ->get(self::FLESPI_API_URL.'/'.$deviceId.'/commands-result/'.$commandId);

            if ($response->successful()) {
                return response()->json([
                    'result' => $response->json()['result'] ?? null,
                    'status' => 'success'
                ]);
            }

            return $this->handleFlespiError($response);

        } catch (\Exception $e) {
            Log::error("Flespi command result error - Device: {$deviceId}, Command: {$commandId}: " . $e->getMessage());
            return $this->errorResponse('Failed to get command result', 500);
        }
    }

    /**
     * Format device data consistently
     */
    private function formatDeviceData($message)
    {
        return [
            'position' => [
                'latitude' => $message['position.latitude'] ?? $message['position']['latitude'] ?? null,
                'longitude' => $message['position.longitude'] ?? $message['position']['longitude'] ?? null,
                'speed' => $message['position.speed'] ?? $message['position']['speed'] ?? null,
                'altitude' => $message['position.altitude'] ?? $message['position']['altitude'] ?? null,
            ],
            'timestamp' => $message['timestamp'] ?? null,
            'utc' => $message['timestamp'] ?? null,
            'battery' => $message['battery.level'] ?? $message['battery'] ?? null,
            'device_id' => $message['device_id'] ?? self::FLESPI_DEVICE_ID
        ];
    }

    /**
     * Format device information for display
     */
    private function formatDeviceInfo($device, $channel = null)
    {
        $data = [
            'id' => $device['id'] ?? null,
            'name' => $device['name'] ?? 'TKSTAR TK905B',
            'model' => $device['model'] ?? 'TK905B',
            'status' => $device['status'] ?? 'unknown',
            'created' => $device['created'] ?? null,
            'last_message' => $device['last_message'] ?? null,
            'protocol_id' => $device['protocol_id'] ?? null,
            'channel_id' => $device['channel_id'] ?? self::FLESPI_CHANNEL_ID,
            'imei' => $device['ident'] ?? '9058148761',
            'channel' => null
        ];

        if ($channel) {
            $data['channel'] = [
                'id' => $channel['id'] ?? null,
                'name' => $channel['name'] ?? 'tk905_channel',
                'protocol_id' => $channel['protocol_id'] ?? null,
                'status' => $channel['status'] ?? null,
                'host' => $channel['config.host'] ?? 'ch1265317.flespi.gw',
                'port' => $channel['config.port'] ?? 22153
            ];
        }

        // Format timestamps
        foreach (['created', 'last_message'] as $field) {
            if (!empty($data[$field])) {
                $data[$field.'_formatted'] = date('Y-m-d H:i:s', $data[$field]);
                $data[$field.'_relative'] = $this->relativeTime($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Handle Flespi API errors consistently
     */
    private function handleFlespiError($response)
    {
        $status = $response->status();
        $error = $response->json()['error'] ?? 'Unknown Flespi API error';
        $message = "Flespi API Error: $error (Status: $status)";

        Log::error($message, [
            'response' => $response->json()
        ]);

        return response()->json([
            'error' => $error,
            'status' => $status,
            'solution' => $this->getErrorSolution($status)
        ], $status);
    }

    /**
     * Standard error response format
     */
    private function errorResponse($message, $code = 500)
    {
        Log::error($message);
        return response()->json([
            'error' => $message,
            'status' => $code
        ], $code);
    }

    /**
     * Validate and get Flespi token
     */
    private function validateToken()
    {
        $token = env('FLESPI_TOKEN');
        if (empty($token) || strlen($token) < 64) { // Flespi tokens are typically 64 chars
            Log::error('Invalid Flespi token configuration - token too short or empty');
            return false;
        }
        return $token;
    }

    /**
     * Get human-readable error solutions
     */
    private function getErrorSolution($statusCode)
    {
        $solutions = [
            400 => 'Check request parameters and token permissions',
            401 => 'Invalid or expired token. Please verify FLESPI_TOKEN in .env',
            403 => 'Token lacks required permissions. Check Flespi token settings',
            404 => 'Device not found. Verify device ID exists in your Flespi account',
            429 => 'Too many requests. Implement request throttling',
            500 => 'Flespi server error. Try again later',
            503 => 'Flespi service unavailable. Try again later'
        ];

        return $solutions[$statusCode] ?? 'Check Flespi API documentation';
    }

    /**
     * Convert timestamp to relative time (e.g., "5 minutes ago")
     */
    private function relativeTime($timestamp)
    {
        $diff = time() - $timestamp;
        if ($diff < 60) {
            return $diff . ' seconds ago';
        }
        $diff = round($diff / 60);
        if ($diff < 60) {
            return $diff . ' minutes ago';
        }
        $diff = round($diff / 60);
        if ($diff < 24) {
            return $diff . ' hours ago';
        }
        $diff = round($diff / 24);
        return $diff . ' days ago';
    }

    // Add this method to handle WebSocket connections
    public function connectWebSocket(Request $request)
    {
        $token = $this->validateToken();
        if (!$token) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        try {
            $wsUrl = "wss://mqtt.flespi.io:443/ws?token=".$token;
            return response()->json(['ws_url' => $wsUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}