<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ManageGPSController extends Controller
{
    public function showManageGPS()
    {
        return view('admin.managegps');
    }

    public function getLiveLocations()
    {
        return Cache::remember('live_locations', 0.5, function () {
            // Get all drivers with assigned trucks
            $drivers = User::where('role', 'driver')
                ->whereNotNull('truck_id')
                ->get();

            // Get all tracking data
            $trackings = Tracking::all()->keyBy('truck_id');

            return $drivers->map(function ($driver) use ($trackings) {
                $tracking = $trackings->get($driver->truck_id);

                return [
                    'truck_id' => $driver->truck_id,
                    'latitude' => $tracking->latitude ?? 0,
                    'longitude' => $tracking->longitude ?? 0,
                    'total_distance' => $tracking->total_distance ?? 0,
                    'speed' => $tracking->speed ?? 0,
                    'fullname' => $driver->fullname,
                    'driver_license_number' => $driver->driver_license_number
                ];
            });
        });
    }

    public function getDriverLocation($truck_id)
    {
        return Cache::remember("driver_location_{$truck_id}", 0.5, function () use ($truck_id) {
            // Get both driver and tracking data
            $driver = User::where('truck_id', $truck_id)
                ->where('role', 'driver')
                ->first();

            $tracking = Tracking::where('truck_id', $truck_id)->first();

            if (!$driver || !$tracking) return null;

            return [
                'truck_id' => $truck_id,
                'latitude' => $tracking->latitude,
                'longitude' => $tracking->longitude,
                'total_distance' => $tracking->total_distance,
                'speed' => $tracking->speed,
                'fullname' => $driver->fullname
            ];
        });
    }

    public function resetDistance($truck_id)
    {
        $updated = DB::table('trackings')
                    ->where('truck_id', $truck_id)
                    ->update(['total_distance' => 0.00]);

        // Clear cache after reset
        Cache::forget('live_locations');
        Cache::forget("driver_location_{$truck_id}");

        return response()->json(['success' => $updated]);
    }

    // Optional method to get all active trucks with their drivers
    public function getAllActiveTrucks()
    {
        return User::where('role', 'driver')
            ->whereNotNull('truck_id')
            ->with(['tracking'])
            ->get()
            ->map(function ($driver) {
                return [
                    'truck_id' => $driver->truck_id,
                    'latitude' => $driver->tracking->latitude ?? 0,
                    'longitude' => $driver->tracking->longitude ?? 0,
                    'total_distance' => $driver->tracking->total_distance ?? 0,
                    'speed' => $driver->tracking->speed ?? 0,
                    'fullname' => $driver->fullname,
                    'driver_license_number' => $driver->driver_license_number
                ];
            });
    }

    public function getPosition()
    {
        $token = env('FLESPI_TOKEN');
        $deviceId = env('FLESPI_DEVICE_ID');
    
        try {
            // First verify device access
            $deviceResponse = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token
            ])->get("https://flespi.io/gw/devices/{$deviceId}");
    
            if ($deviceResponse->status() === 403) {
                return response()->json([
                    'error' => 'Token lacks permissions',
                    'solution' => '1. Regenerate token 2. Add device access 3. Set devices:read permission'
                ], 403);
            }
    
            // Then get position data
            $positionResponse = Http::withHeaders([
                'Authorization' => 'FlespiToken ' . $token
            ])->get("https://flespi.io/gw/devices/{$deviceId}/messages?limit=1&fields=position");
    
            return response()->json(
                $positionResponse->json(),
                $positionResponse->status()
            );
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'solution' => 'Check server connection and token validity'
            ], 500);
        }
    }
} 