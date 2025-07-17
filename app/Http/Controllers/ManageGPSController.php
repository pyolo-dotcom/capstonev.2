<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Tracking;
use App\Models\Truck; // Add this import
use App\Models\FuelConsumption; // Add this import
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

    public function resetDistance($truck_id, Request $request)
    {
        try {
            DB::beginTransaction();
    
            // Get the current distance before resetting
            $tracking = Tracking::where('truck_id', $truck_id)->firstOrFail();
            $totalKm = $tracking->total_distance ?? 0;
    
            // Reset the distance to 0
            $tracking->total_distance = 0;
            $tracking->save();
    
            // If there was distance traveled, record fuel consumption
            if ($totalKm > 0) {
                $truck = Truck::where('plate_number', $truck_id)->firstOrFail();
                
                $avgKmL = $truck->average_km_l ?? 5; // Default to 5 if not set
                $currentFuelPrice = $request->input('fuel_price', 60.00); // Get from request or default
    
                FuelConsumption::create([
                    'date' => now()->format('Y-m-d'),
                    'plate_no' => $truck_id,
                    'total_km' => $totalKm,
                    'avg_km_l' => $avgKmL,
                    'total_liters' => $totalKm / $avgKmL,
                    'fuel_price' => $currentFuelPrice,
                    'total_cost' => ($totalKm / $avgKmL) * $currentFuelPrice
                ]);
            }
    
            // Clear cache after reset
            Cache::forget('live_locations');
            Cache::forget("driver_location_{$truck_id}");
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => $totalKm > 0 
                    ? 'Distance reset and fuel consumption recorded' 
                    : 'Distance reset'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Reset distance error for truck {$truck_id}: ".$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error resetting distance: '.$e->getMessage()
            ], 500);
        }
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