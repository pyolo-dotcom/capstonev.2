<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class ActiveController extends Controller
{
    // Ipakita ang active accounts
    public function showActive()
    {
        // Kunin ang lahat ng active users
        $users = User::all(); 
        
        // I-pasa ang data sa view
        return view('admin.activeaccount', compact('users'));
    }

    // I-edit ang user account
    public function edit(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Validate input
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:driver,manager,admin',
            'driver_license_number' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:255',
            'license_expiry_date' => 'nullable|date',
            'truck_id' => 'nullable|string|max:255',
        ]);
    
        // Update user details
        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'driver_license_number' => $request->driver_license_number,
            'license_type' => $request->license_type,
            'license_expiry_date' => $request->license_expiry_date,
            'truck_id' => $request->role === 'driver' ? $request->truck_id : null, // Only store truck_id if the role is 'driver'
        ]);
    
        return redirect()->route('admin.activeaccount')->with('success', 'Account updated successfully.');
    }    

    // I-archive ang user account (Soft Delete)
    public function archive($id)
    {
        // Hanapin ang user base sa ID
        $user = User::findOrFail($id);

        // I-soft delete ang user
        $user->delete();

        // I-redirect pabalik sa active accounts page na may success message
        return redirect()->route('admin.activeaccount')->with('success', 'Account archived successfully.');
    }

    // I-create ang bagong user account
public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|unique:users',
        'fullname' => 'required|string',
        'email' => 'required|email|unique:users',
        'dob' => 'required|date',
        'role' => 'required|string',
        'password' => 'required|confirmed|min:6',
        // Only validate these fields if role is "driver"
        'driver_license_number' => 'nullable|string',
        'license_type' => 'nullable|string',
        'license_expiry_date' => 'nullable|date',
        'truck_id' => 'nullable|string',
    ]);

    $user = new User();
    $user->username = $request->username;
    $user->fullname = $request->fullname;
    $user->email = $request->email;
    $user->dob = $request->dob;
    $user->role = $request->role;
    $user->password = bcrypt($request->password);

    // Save driver-specific fields only if the role is "driver"
    if ($request->role === 'driver') {
        $user->driver_license_number = $request->driver_license_number;
        $user->license_type = $request->license_type;
        $user->license_expiry_date = $request->license_expiry_date;
        $user->truck_id = $request->truck_id;
    }

    $user->save();

    return redirect()->route('admin.activeaccount')->with('success', 'Account created successfully.');
}
    
}