<?php

// app/Http/Controllers/ManageGPSController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GpsData;

class ManageGPSController extends Controller
{
    public function showManageGPS()
    {
        // Kunin ang latest GPS data
        $gpsData = GpsData::latest()->first();
        return view('admin.managegps', compact('gpsData'));
    }

    public function storeGpsData(Request $request)
    {
        // I-validate ang data
        $request->validate([
            'device_id' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // I-save ang GPS data sa database
        GpsData::create([
            'device_id' => $request->device_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => now(),
        ]);

        return response()->json(['message' => 'GPS data saved successfully']);
    }

    public function fetchGpsData()
    {
        // Kunin ang latest GPS data
        $gpsData = GpsData::latest()->first();
        return response()->json($gpsData);
    }
}