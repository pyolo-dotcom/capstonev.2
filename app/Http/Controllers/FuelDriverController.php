<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelConsumption;

class FuelDriverController extends Controller
{
    // Ipakita ang fuel management page para sa driver
    public function showFuelDriver()
    {
        return view('driver.fuel');
    }

    // Mag-add ng bagong fuel consumption
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

    // Kunin ang fuel analytics data para sa chart
    public function getFuelAnalytics(Request $request)
    {
        $plateNumber = $request->input('plate_number');
        $timeFilter = $request->input('time_filter');

        $query = FuelConsumption::query();

        if ($plateNumber !== 'all') {
            $query->where('plate_no', $plateNumber);
        }

        // Apply date filtering based on selected time filter
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