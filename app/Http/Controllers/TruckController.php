<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TruckController extends Controller
{
    /**
     * Display all trucks
     */
    public function showTruck()
    {
        $trucks = Truck::orderBy('id')->get();
        return view('admin.truckdetails', compact('trucks'));
    }

    /**
     * Store a new truck
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cr_number' => 'required|string|max:255',
            'date' => 'required|date',
            'mv_file_number' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:trucks',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'denomination' => 'required|string|max:255',
            'piston_displacement' => 'required|string|max:255',
            'number_of_cylinders' => 'required|string|max:255',
            'fuel' => 'required|string|max:255',
            'average_km_l' => 'required|numeric|min:1|max:50',
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

        try {
            // Store image
            $imagePath = $request->file('image')->store('trucks', 'public');
            $validated['image_path'] = $imagePath;

            Truck::create($validated);

            return redirect()->route('admin.truckdetails')
                   ->with('success', 'Truck added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                   ->with('error', 'Error adding truck: ' . $e->getMessage())
                   ->withInput();
        }
    }

    /**
     * Update an existing truck
     */
    public function update(Request $request, $id)
    {
        $truck = Truck::findOrFail($id);

        $validated = $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'cr_number' => 'required|string|max:255',
            'date' => 'required|date',
            'mv_file_number' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:trucks,plate_number,'.$id,
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'denomination' => 'required|string|max:255',
            'piston_displacement' => 'required|string|max:255',
            'number_of_cylinders' => 'required|string|max:255',
            'fuel' => 'required|string|max:255',
            'average_km_l' => 'required|numeric|min:1|max:50',
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
            'remove_image' => 'sometimes|boolean',
        ]);

        try {
            // Handle image removal
            if ($request->has('remove_image')) {
                $truck->deleteImageFile();
                $validated['image_path'] = null;
            }
            // Handle image update
            elseif ($request->hasFile('image')) {
                // Delete old image
                $truck->deleteImageFile();
                
                // Store new image
                $imagePath = $request->file('image')->store('trucks', 'public');
                $validated['image_path'] = $imagePath;
            }

            $truck->update($validated);

            return redirect()->route('admin.truckdetails')
                   ->with('success', 'Truck updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                   ->with('error', 'Error updating truck: ' . $e->getMessage())
                   ->withInput();
        }
    }

    /**
     * Delete a truck
     */
    public function destroy($id)
    {
        try {
            $truck = Truck::findOrFail($id);
            
            // Delete the image file
            $truck->deleteImageFile();
            
            // Delete the record
            $truck->delete();

            return redirect()->route('admin.truckdetails')
                   ->with('success', 'Truck archived successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                   ->with('error', 'Error archiving truck: ' . $e->getMessage());
        }
    }
}