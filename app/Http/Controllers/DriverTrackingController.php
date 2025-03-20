<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Tracking;

class DriverTrackingController extends Controller
{
    public function updateLocation(Request $request)
    {
        try {
            $data = $request->all();
            $truckId = $data['truck_id'];
            $newLat = $data['latitude'];
            $newLon = $data['longitude'];
    
            // Get the last known location
            $lastLocation = DB::table('trackings')
                ->where('truck_id', $truckId)
                ->orderBy('created_at', 'desc')
                ->first();
    
            $totalDistance = 0;
            $distance = 0;
    
            if ($lastLocation) {
                // Calculate distance
                $distance = $this->haversineDistance(
                    $lastLocation->latitude, $lastLocation->longitude,
                    $newLat, $newLon
                );
                $totalDistance = $lastLocation->total_distance + $distance;
            }
    
            // Store new location and total distance
            DB::table('trackings')->updateOrInsert(
                ['truck_id' => $truckId],
                [
                    'latitude' => $newLat,
                    'longitude' => $newLon,
                    'total_distance' => round($totalDistance, 2),
                    'updated_at' => now()
                ]
            );
    
            \Log::info("📡 Updated Truck $truckId | Distance Added: " . round($distance, 2) . " km | Total: " . round($totalDistance, 2) . " km");
    
            // ✅ Fix: Return a proper JSON response
            return response()->json([
                'status' => 'success',
                'truck_id' => $truckId,
                'new_latitude' => $newLat,
                'new_longitude' => $newLon,
                'added_distance' => round($distance, 2),
                'total_distance' => round($totalDistance, 2),
            ]);
    
        } catch (\Exception $e) {
            // ❌ Handle errors properly
            \Log::error("Error updating location: " . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update location',
                'error' => $e->getMessage()
            ], 500);
        }
    }    
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $R = 6371; // Earth's radius in km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c;
}
}
