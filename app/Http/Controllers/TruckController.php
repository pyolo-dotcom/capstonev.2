<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;

class TruckController extends Controller
{
    public function showTruck()
    {
        $trucks = Truck::all();
        return view('admin.truckdetails', compact('trucks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cr_number' => 'required|string|max:255',
            'date' => 'required|date',
            'mv_file_number' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'denomination' => 'required|string|max:255',
            'piston_displacement' => 'required|string|max:255',
            'number_of_cylinders' => 'required|string|max:255',
            'fuel' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'series' => 'required|string|max:255',
            'body_type' => 'required|string|max:255',
            'body_number' => 'required|string|max:255',
            'year_model' => 'required|string|max:255',
            'gross_weight' => 'required|string|max:255',
            'net_weight' => 'required|string|max:255',
            'shipping_weight' => 'required|string|max:255',
            'net_capacity' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Truck::create($validated);

        return redirect()->route('admin.truckdetails')->with('success', 'Truck registered successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cr_number' => 'required|string|max:255',
            'date' => 'required|date',
            'mv_file_number' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'denomination' => 'required|string|max:255',
            'piston_displacement' => 'required|string|max:255',
            'number_of_cylinders' => 'required|string|max:255',
            'fuel' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'series' => 'required|string|max:255',
            'body_type' => 'required|string|max:255',
            'body_number' => 'required|string|max:255',
            'year_model' => 'required|string|max:255',
            'gross_weight' => 'required|string|max:255',
            'net_weight' => 'required|string|max:255',
            'shipping_weight' => 'required|string|max:255',
            'net_capacity' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $truck = Truck::findOrFail($id);
        $truck->update($validated);

        return redirect()->route('admin.truckdetails')->with('success', 'Truck updated successfully!');
    }

    public function destroy($id)
    {
        $truck = Truck::findOrFail($id);
        $truck->delete();

        return redirect()->route('admin.truckdetails')->with('success', 'Truck archived successfully!');
    }
}