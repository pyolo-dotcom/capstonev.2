<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tracking;

class DriverTrackingController extends Controller
{
    public function updateLocation(Request $request) {
        Log::info("📡 Received update", ['data' => $request->all()]);
    
        $request->validate([
            'truck_id' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
    
        Tracking::updateOrCreate(
            ['truck_id' => $request->truck_id], 
            ['latitude' => $request->latitude, 'longitude' => $request->longitude, 'updated_at' => now()]
        );
    
        Log::info("✅ Updated Truck ID: " . $request->truck_id);
    
        return response()->json(['success' => true]);
    }   
}
