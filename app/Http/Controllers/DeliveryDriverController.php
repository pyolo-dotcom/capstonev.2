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
    // Remove spaces from plate number to match database format
    $plateNo = str_replace(' ', '', $request->input('plate_no'));

    Log::info("Received Plate Number (Formatted): " . $plateNo); // Debugging

    // Define separate queries for each trip type
    $oneWayTripQuery = Trip::query();
    $roundTripQuery = Trip::query();
    $doorToDoorTripQuery = Trip::query();

    if ($plateNo !== 'All') {
        $oneWayTripQuery->where('plate_no', $plateNo);
        $roundTripQuery->where('plate_no', $plateNo);
        $doorToDoorTripQuery->where('plate_no', $plateNo);
    }

    // Sum num_trips for each trip type separately
    $oneWayTrip = $oneWayTripQuery->where('trip_type', 'One Way Trip')->sum('num_trips');
    $roundTrip = $roundTripQuery->where('trip_type', 'Round Trip')->sum('num_trips');
    $doorToDoorTrip = $doorToDoorTripQuery->where('trip_type', 'Door-To-Door Trip')->sum('num_trips');

    // Debugging output
    Log::info("Trip Counts: ", [
        'plateNo' => $plateNo,
        'oneWayTrip' => $oneWayTrip,
        'roundTrip' => $roundTrip,
        'doorToDoorTrip' => $doorToDoorTrip
    ]);

    return response()->json([
        'oneWayTrip' => $oneWayTrip,
        'roundTrip' => $roundTrip,
        'doorToDoorTrip' => $doorToDoorTrip,
    ]);
}
}