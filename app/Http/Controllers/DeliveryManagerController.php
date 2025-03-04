<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Trip;

class DeliveryManagerController extends Controller
{
    public function showDeliveryManager()
    {
        // Fetch all trip records
        $trips = Trip::all();

        // Default counts set to zero (so no trips appear initially)
        $oneWayTrip = 0;
        $roundTrip = 0;
        $doorToDoorTrip = 0;

        return view('manager.deliveryrecords', compact('trips', 'oneWayTrip', 'roundTrip', 'doorToDoorTrip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_no' => 'required',
            'trip_type' => 'required',
            'num_trips' => 'required|integer|min:1',
        ]);

        Trip::create($request->all());

        return response()->json(['message' => 'Trip added successfully!']);
    }

    // Update a trip
    public function update(Request $request, $id)
    {
        $request->validate([
            'plate_no' => 'required',
            'trip_type' => 'required',
            'num_trips' => 'required|integer|min:1',
        ]);

        $trip = Trip::findOrFail($id);
        $trip->update($request->all());

        return response()->json(['message' => 'Trip updated successfully!']);
    }

    // Reset trips of a certain typepublic function reset(Request $request)
    public function reset(Request $request)
    {
        $request->validate([
            'plate_no' => 'required', // Ensure plate number is provided
            'trip_type' => 'required'
        ]);
    
        // Find trips that match the given plate number and trip type
        $deleted = Trip::where('plate_no', $request->plate_no)
            ->where('trip_type', $request->trip_type)
            ->delete();
    
        if ($deleted) {
            return response()->json(['message' => 'Trips reset successfully for ' . $request->plate_no]);
        } else {
            return response()->json(['message' => 'No trips found to reset for ' . $request->plate_no], 404);
        }
    }
    
}