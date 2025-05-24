<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelConsumption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Truck;

class FuelController extends Controller
{
    public function showFuel(){
        $plateNumbers = Truck::pluck('plate_number')->unique()->sort()->values()->all();
        $fuelData = FuelConsumption::all();
        return view('admin.fuel', compact('fuelData', 'plateNumbers'));
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
public function edit($id)
{
    try {
        $fuel = FuelConsumption::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $fuel->id,
                'date' => $fuel->date,
                'plate_no' => $fuel->plate_no,
                'total_km' => $fuel->total_km,
                'avg_km_l' => $fuel->avg_km_l,
                'fuel_price' => $fuel->fuel_price,
                'total_liters' => $fuel->total_liters,
                'total_cost' => $fuel->total_cost
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        'plateNo' => 'required|string|max:20',
        'totalKm' => 'required|numeric|min:0',
        'avgKmL' => 'required|numeric|min:0',
        'fuelPrice' => 'required|numeric|min:0',
        'totalLiters' => 'required|numeric|min:0',
        'totalCost' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $consumption = FuelConsumption::findOrFail($id);
        $consumption->update([
            'date' => $request->input('date'),
            'plate_no' => $request->input('plateNo'),
            'total_km' => $request->input('totalKm'),
            'avg_km_l' => $request->input('avgKmL'),
            'fuel_price' => $request->input('fuelPrice'),
            'total_liters' => $request->input('totalLiters'),
            'total_cost' => $request->input('totalCost'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fuel consumption updated successfully',
            'data' => $consumption
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update fuel consumption',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function archive($id)
    {
        $fuel = FuelConsumption::findOrFail($id);
        $fuel->delete();
        return redirect()->route('admin.fuel')->with('success', 'Fuel consumption archived successfully.');
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