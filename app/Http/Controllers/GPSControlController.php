<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Tracking;
use App\Models\Truck;
use App\Models\FuelConsumption;
use Illuminate\Http\Request;

class GPSControlController extends Controller
{
    public function showGPSControl()
    {
        return view('manager.gpscontrol');
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
}