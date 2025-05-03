<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class DeliveryManagerController extends Controller
{
    public function showDeliveryManager()
    {
        // Fetch all trip records with consistent plate number formatting
        $trips = Trip::select('id', 'plate_no', 'trip_type', 'num_trips')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($trip) {
                $trip->plate_no = trim(str_replace(' ', '', $trip->plate_no));
                return $trip;
            });
    
        // Initialize all counts to zero
        return view('manager.deliveryrecords', [
            'trips' => $trips,
            'oneWayTrip' => 0,
            'roundTrip' => 0,
            'doorToDoorTrip' => 0
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plate_no' => 'required',
            'trip_type' => 'required',
            'num_trips' => 'required|integer|min:1',
        ]);

        // Clean plate number by removing spaces and convert to uppercase
        $cleanPlateNo = strtoupper(str_replace(' ', '', $request->plate_no));

        // Find the trip
        $trip = Trip::where('id', $id)->firstOrFail();

        // Update the trip details
        $trip->update([
            'plate_no' => $cleanPlateNo,
            'trip_type' => $request->trip_type,
            'num_trips' => $request->num_trips
        ]);

        return response()->json(['message' => 'Trip updated successfully!']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'plate_no' => 'required',
            'trip_type' => 'required'
        ]);
    
        // Clean plate number format
        $cleanPlateNo = strtoupper(str_replace(' ', '', $request->plate_no));
    
        // Find and delete matching trips
        $deleted = Trip::where(DB::raw("REPLACE(UPPER(plate_no), ' ', '')"), $cleanPlateNo)
            ->where('trip_type', $request->trip_type)
            ->delete();
    
        if ($deleted) {
            return response()->json(['message' => 'Trips reset successfully for ' . $cleanPlateNo]);
        } else {
            return response()->json(['message' => 'No trips found to reset for ' . $cleanPlateNo], 404);
        }
    }

    public function getTripCounts(Request $request)
    {
        $plateNo = strtoupper(str_replace(' ', '', $request->input('plate_no')));
        
        if (empty($plateNo)) {
            return response()->json([
                'oneWayTrip' => 0,
                'roundTrip' => 0,
                'doorToDoorTrip' => 0
            ]);
        }

        // Use consistent formatting for comparison
        $trips = Trip::select('trip_type', DB::raw('SUM(num_trips) as total_trips'))
            ->where(DB::raw("REPLACE(UPPER(plate_no), ' ', '')"), $plateNo)
            ->groupBy('trip_type')
            ->get();

        $counts = [
            'oneWayTrip' => 0,
            'roundTrip' => 0,
            'doorToDoorTrip' => 0
        ];

        foreach ($trips as $trip) {
            switch ($trip->trip_type) {
                case 'One Way Trip':
                    $counts['oneWayTrip'] = (int)$trip->total_trips;
                    break;
                case 'Round Trip':
                    $counts['roundTrip'] = (int)$trip->total_trips;
                    break;
                case 'Door-To-Door Trip':
                    $counts['doorToDoorTrip'] = (int)$trip->total_trips;
                    break;
            }
        }

        return response()->json($counts);
    }
}