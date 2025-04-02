<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ActiveController extends Controller
{
    /**
     * Display all active accounts
     */
    public function showActive()
    {
        $users = User::all(); 
        return view('admin.activeaccount', compact('users'));
    }

    /**
     * Edit user account
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:20',
            'dob' => 'required|date',
            'role' => 'required|in:driver,manager,admin',
            'driver_license_number' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:255',
            'license_expiry_date' => 'nullable|date',
            'truck_id' => 'nullable|string|in:UVP353,TQE262,NBB7212,APA3309,WIE914',
        ]);
    
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
            'truck_id' => $request->role === 'driver' ? $request->truck_id : null,
        ]);
    
        return redirect()->route('admin.activeaccount')->with('success', 'Account updated successfully.');
    }

    /**
     * Archive user account (Soft Delete)
     */
    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.activeaccount')->with('success', 'Account archived successfully.');
    }

    /**
     * Create new user account
     */
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
            'truck_id' => 'nullable|required_if:role,driver|string|in:UVP353,TQE262,NBB7212,APA3309,WIE914',
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

        return redirect()->route('admin.activeaccount')->with('success', 'Account created successfully.');
    }

    /**
     * Restore archived account
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.archive')->with('success', 'Account restored successfully.');
    }

    /**
     * Permanently delete account
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.archive')->with('success', 'Account permanently deleted.');
    }
}