<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tracking;
use App\Models\User;
use App\Events\LocationUpdated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class DriverTrackingController extends Controller
{
    public function updateLocation(Request $request)
    {
        $limiter = app(RateLimiter::class);
        $key = 'location-update:' . ($request->ip() . '|' . $request->input('truck_id'));

        if ($limiter->tooManyAttempts($key, 2)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Too many requests'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $limiter->hit($key, 1);

        try {
            $validated = $request->validate([
                'truck_id' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'total_distance' => 'numeric',
                'speed' => 'numeric',
                'timestamp' => 'required|date'
            ]);

            $truckId = $validated['truck_id'];
            $newLat = $validated['latitude'];
            $newLon = $validated['longitude'];
            $clientSpeed = $validated['speed'] ?? 0;
            $timestamp = Carbon::parse($validated['timestamp']);

            // Get the last known location
            $lastLocation = Tracking::where('truck_id', $truckId)
                ->latest()
                ->first();

            $totalDistance = $validated['total_distance'] ?? 0;
            $distance = 0;

            if ($lastLocation) {
                $distance = $this->haversineDistance(
                    $lastLocation->latitude, 
                    $lastLocation->longitude,
                    $newLat, 
                    $newLon
                );
                $totalDistance = $lastLocation->total_distance + $distance;
            }

            // Use client-provided speed if available and valid, otherwise calculate
            $speed = $clientSpeed > 0 ? $clientSpeed : $this->calculateSpeed($lastLocation, $newLat, $newLon, $timestamp);

            // Store new location
            $tracking = Tracking::updateOrCreate(
                ['truck_id' => $truckId],
                [
                    'latitude' => $newLat,
                    'longitude' => $newLon,
                    'total_distance' => round($totalDistance, 2),
                    'speed' => $speed,
                    'updated_at' => $timestamp
                ]
            );

            // Get driver info
            $driver = User::where('truck_id', $truckId)
                        ->where('role', 'driver')
                        ->first();

            // Broadcast the update
            event(new LocationUpdated($truckId, [
                'truck_id' => $truckId,
                'latitude' => $newLat,
                'longitude' => $newLon,
                'total_distance' => round($totalDistance, 2),
                'speed' => $speed,
                'fullname' => $driver->fullname ?? 'Unknown Driver',
                'driver_license_number' => $driver->driver_license_number ?? '',
                'timestamp' => $timestamp->toDateTimeString()
            ]));

            return response()->json([
                'status' => 'success',
                'truck_id' => $truckId,
                'distance_added' => round($distance, 2),
                'total_distance' => round($totalDistance, 2),
                'speed' => $speed
            ]);

        } catch (\Exception $e) {
            Log::error("Location update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Location update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Earth radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    private function calculateSpeed($lastLocation, $newLat, $newLon, $currentTime)
    {
        if (!$lastLocation) return 0;
        
        $distance = $this->haversineDistance(
            $lastLocation->latitude,
            $lastLocation->longitude,
            $newLat,
            $newLon
        );
        
        $timeDiff = $currentTime->diffInSeconds($lastLocation->updated_at);
        
        // Minimum 1 second to prevent division by zero and unrealistic speeds
        $timeDiff = max(1, $timeDiff);
        
        $speed = ($distance / $timeDiff) * 3600; // km/h
        
        // Ensure speed is never negative and has a reasonable maximum (120 km/h)
        return min(max(0, $speed), 120);
    }
}