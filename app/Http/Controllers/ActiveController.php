<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Truck;
use App\Models\Tracking;
use Illuminate\Validation\Rule;

class ActiveController extends Controller
{
    public function showActive()
    {
        $users = User::where('role', '!=', 'admin')->get(); 
        return view('admin.activeaccount', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|string|max:20',
            'dob' => 'required|date',
            'role' => 'required|string|in:driver,manager,admin',
            'password' => 'required|confirmed|min:6',
            'driver_license_number' => 'nullable|required_if:role,driver|string',
            'license_type' => 'nullable|required_if:role,driver|string',
            'license_expiry_date' => 'nullable|required_if:role,driver|date',
            'truck_id' => [
                'nullable',
                'required_if:role,driver',
                'string',
                Rule::unique('users', 'truck_id')->where(function ($query) {
                    return $query->where('role', 'driver');
                })
            ],
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'dob' => $request->dob,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'driver_license_number' => $request->driver_license_number,
            'license_type' => $request->license_type,
            'license_expiry_date' => $request->license_expiry_date,
            'truck_id' => $request->role === 'driver' ? $request->truck_id : null,
        ]);

        // Create tracking record for drivers
        if ($request->role === 'driver' && $request->truck_id) {
            Tracking::updateOrCreate(
                ['truck_id' => $request->truck_id],
                [
                    'latitude' => 0,
                    'longitude' => 0,
                    'speed' => 0,
                    'total_distance' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        return redirect()->route('admin.activeaccount')->with('success', 'Account created successfully.');
    }

    public function editForm($id)
    {
        $user = User::findOrFail($id);
        
        $assignedTrucks = User::where('role', 'driver')
            ->whereNotNull('truck_id')
            ->where('id', '!=', $id)
            ->pluck('truck_id');
            
        $trucks = Truck::where(function($query) use ($assignedTrucks, $user) {
            $query->whereNotIn('plate_number', $assignedTrucks)
                  ->orWhere('plate_number', $user->truck_id);
        })->get();
        
        return response()->json([
            'user' => $user,
            'trucks' => $trucks
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'mobile_number' => 'required|string|max:20',
            'dob' => 'required|date',
            'role' => 'required|in:driver,manager,admin',
            'driver_license_number' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:255',
            'license_expiry_date' => 'nullable|date',
            'truck_id' => [
                'nullable',
                'string',
                Rule::unique('users', 'truck_id')->where(function ($query) {
                    return $query->where('role', 'driver');
                })->ignore($id)
            ],
        ]);

        $oldTruckId = $user->truck_id;
        $newTruckId = $request->role === 'driver' ? $request->truck_id : null;

        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'dob' => $request->dob,
            'role' => $request->role,
            'driver_license_number' => $request->driver_license_number,
            'license_type' => $request->license_type,
            'license_expiry_date' => $request->license_expiry_date,
            'truck_id' => $newTruckId,
        ]);

        // Handle tracking record updates
        if ($request->role === 'driver') {
            if ($oldTruckId !== $newTruckId) {
                // Remove tracking for old truck if it's not assigned to another driver
                if ($oldTruckId && !User::where('truck_id', $oldTruckId)->where('id', '!=', $id)->exists()) {
                    Tracking::where('truck_id', $oldTruckId)->delete();
                }
                
                // Create tracking for new truck
                if ($newTruckId) {
                    Tracking::updateOrCreate(
                        ['truck_id' => $newTruckId],
                        [
                            'latitude' => 0,
                            'longitude' => 0,
                            'speed' => 0,
                            'total_distance' => 0,
                            'updated_at' => now()
                        ]
                    );
                }
            }
        } else {
            // If user is no longer a driver, remove their tracking if no other driver uses the truck
            if ($oldTruckId && !User::where('truck_id', $oldTruckId)->where('id', '!=', $id)->exists()) {
                Tracking::where('truck_id', $oldTruckId)->delete();
            }
        }

        return redirect()->route('admin.activeaccount')->with('success', 'Account updated successfully.');
    }

    public function archive($id)
    {
        $user = User::findOrFail($id);
        $truckId = $user->truck_id;
        
        $user->delete();
        
        // Remove tracking if no other driver uses this truck
        if ($truckId && !User::where('truck_id', $truckId)->where('id', '!=', $id)->exists()) {
            Tracking::where('truck_id', $truckId)->delete();
        }

        return redirect()->route('admin.activeaccount')->with('success', 'Account archived successfully.');
    }
}