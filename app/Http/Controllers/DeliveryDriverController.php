<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Log; 

class DeliveryDriverController extends Controller
{
    public function index(){
        return view('driver.deliveryrecords');
    }
    public function store(Request $request)
    {
        $request->validate([
            'plate_no' => 'required|string',
            'trip_type' => 'required|string',
            'num_trips' => 'required|integer|min:1',
        ]);
    
        Trip::create([
            'plate_no' => $request->plate_no,
            'trip_type' => $request->trip_type,
            'num_trips' => $request->num_trips,
        ]);
    
        return response()->json(['success' => 'Trip added successfully!']);
    }
    public function getTripCounts(Request $request)
    {
        // Remove spaces from the input to match database format
        $plateNo = str_replace(' ', '', $request->input('plate_no'));
    
        Log::info("Received Plate Number (Formatted): " . $plateNo); // Debugging
    
        // Fetch trip data from the database with corrected plate number formatting
        $trips = Trip::whereRaw("REPLACE(plate_no, ' ', '') = ?", [$plateNo])
            ->groupBy('trip_type')
            ->selectRaw('trip_type, SUM(num_trips) as total_trips')
            ->get();
    
        // Initialize counts
        $counts = [
            'oneWayTrip' => 0,
            'roundTrip' => 0,
            'doorToDoorTrip' => 0
        ];
    
        // Map the results
        foreach ($trips as $trip) {
            if ($trip->trip_type === 'One Way Trip') {
                $counts['oneWayTrip'] = $trip->total_trips;
            } elseif ($trip->trip_type === 'Round Trip') {
                $counts['roundTrip'] = $trip->total_trips;
            } elseif ($trip->trip_type === 'Door-To-Door Trip') {
                $counts['doorToDoorTrip'] = $trip->total_trips;
            }
        }
    
        // Debugging output
        Log::info("Trip Counts: ", [
            'plateNo' => $plateNo,
            'oneWayTrip' => $counts['oneWayTrip'],
            'roundTrip' => $counts['roundTrip'],
            'doorToDoorTrip' => $counts['doorToDoorTrip']
        ]);
    
        return response()->json($counts);
    }     
}