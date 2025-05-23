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
    try {
        // Validate the request data
        $validated = $request->validate([
            'date' => 'required|date',
            'plateNo' => 'required|string|max:255',
            'totalKm' => 'required|numeric|min:0',
            'avgKmL' => 'required|numeric|min:0.1',
            'totalLiters' => 'required|numeric|min:0',
            'fuelPrice' => 'required|numeric|min:0',
            'totalCost' => 'required|numeric|min:0',
        ]);

        // Create new record
        $consumption = FuelConsumption::create([
            'date' => $validated['date'],
            'plate_no' => $validated['plateNo'],
            'total_km' => $validated['totalKm'],
            'avg_km_l' => $validated['avgKmL'],
            'total_liters' => $validated['totalLiters'],
            'fuel_price' => $validated['fuelPrice'],
            'total_cost' => $validated['totalCost'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fuel consumption added successfully!',
            'data' => $consumption
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Fuel consumption save error: '.$e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: '.$e->getMessage()
        ], 500);
    }
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
