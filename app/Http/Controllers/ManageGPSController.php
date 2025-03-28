<?php

// app/Http/Controllers/ManageGPSController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GpsData;

class ManageGPSController extends Controller
{
    public function showManageGPS()
    {
        // Kunin ang latest GPS data
        $gpsData = GpsData::latest()->first();
        return view('admin.managegps', compact('gpsData'));
    }

    public function resetDistance($truck_id)
    {
        $updated = DB::table('trackings')
                    ->where('truck_id', $truck_id)
                    ->update(['total_distance' => 0.00]);
    
        return response()->json(['success' => $updated]);
    }
}