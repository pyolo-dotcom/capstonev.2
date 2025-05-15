<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuelConsumption;
use Illuminate\Support\Facades\Log;
use App\Models\Truck;

class FuelManagerController extends Controller
{
    public function showFuelManager()
    {
        // Get all distinct plate numbers from trucks table
        $plateNumbers = Truck::pluck('plate_number')->unique()->sort()->values()->all();
        
        return view('manager.fuel', compact('plateNumbers'));
    }

    public function store(Request $request)
    {
        \Log::info('Received data:', $request->all()); // Log request data
    
        $request->validate([
            'date' => 'required|date',
            'plateNo' => 'required|string',
            'totalKm' => 'required|integer',
            'avgKmL' => 'required|numeric',
        ]);
    
        $totalLiters = $request->totalKm / $request->avgKmL;
    
        FuelConsumption::create([
            'date' => $request->date,
            'plate_no' => $request->plateNo,
            'total_km' => $request->totalKm,
            'avg_km_l' => $request->avgKmL,
            'total_liters' => $totalLiters,
        ]);
    
        return response()->json(['success' => true, 'message' => 'Fuel consumption added successfully!'], 200);
    }
    
    public function getFuelAnalytics(Request $request)
    {
        $plateNumber = $request->input('plate_number');
        $timeFilter = $request->input('time_filter');
    
        $query = FuelConsumption::query();
    
        if ($plateNumber !== 'all') {
            $query->where('plate_no', $plateNumber);
        }
    
        if ($timeFilter === 'weekly') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($timeFilter === 'monthly') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($timeFilter === 'yearly') {
            $query->whereYear('date', now()->year);
        }
    
        try {
            $fuelData = $query->select('date', 'total_km', 'total_liters')->get(); // Include 'date' field
    
            if ($fuelData->isEmpty()) {
                return response()->json(["message" => "No data found"], 404);
            }
    
            return response()->json($fuelData);
        } catch (\Exception $e) {
            Log::error("Fuel Analytics Error: " . $e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }    
}
