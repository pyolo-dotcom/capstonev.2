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
        ]);

        // I-update ang user
        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
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
}