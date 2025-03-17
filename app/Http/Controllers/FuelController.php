<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelConsumption;

class FuelController extends Controller
{
    public function showFuel(){
        $fuelData = FuelConsumption::all();
        return view('admin.fuel', compact('fuelData'));
    }

    public function store(Request $request)
    {
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

    public function edit($id)
    {
        $fuel = FuelConsumption::findOrFail($id);
        return response()->json($fuel);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'plateNo' => 'required|string',
            'totalKm' => 'required|integer',
            'avgKmL' => 'required|numeric',
        ]);

        $totalLiters = $request->totalKm / $request->avgKmL;

        $fuel = FuelConsumption::findOrFail($id);
        $fuel->update([
            'date' => $request->date,
            'plate_no' => $request->plateNo,
            'total_km' => $request->totalKm,
            'avg_km_l' => $request->avgKmL,
            'total_liters' => $totalLiters,
        ]);

        return response()->json(['success' => true, 'message' => 'Fuel consumption updated successfully!'], 200);
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

        $fuelData = $query->select('total_km', 'total_liters')->get();

        return response()->json($fuelData);
    }
}