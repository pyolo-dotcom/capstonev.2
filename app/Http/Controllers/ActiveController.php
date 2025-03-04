<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class ActiveController extends Controller
{
    public function showActive()
    {
        // Fetch users with active status
        $users = User::all(); 
        
        // Pass the data to the view
        return view('admin.activeaccount', compact('users'));
    }
}
