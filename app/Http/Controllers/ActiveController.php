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
        // Hanapin ang user base sa ID
        $user = User::findOrFail($id);

        // I-validate ang input
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:driver,manager,admin',
            'truck_id' => 'nullable|string|max:255', // Dagdag na validation para sa truck_id
        ]);

        // I-update ang user
        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'truck_id' => $request->role === 'driver' ? $request->truck_id : null, // I-set ang truck_id kung driver ang role
        ]);

        // I-redirect pabalik sa active accounts page na may success message
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
        // I-validate ang input
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'dob' => 'nullable|date',
            'role' => 'required|in:driver,manager,admin',
            'password' => 'required|string|min:8|confirmed',
            'truck_id' => 'nullable|string|max:255', // Gawing optional ang truck_id
        ]);

        // Gumawa ng bagong user
        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'dob' => $request->dob,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'truck_id' => $request->role === 'driver' ? $request->truck_id : null, // I-set ang truck_id kung driver lang
        ]);

        // I-redirect pabalik sa active accounts page na may success message
        return redirect()->route('admin.activeaccount')->with('success', 'Account created successfully.');
    }
}