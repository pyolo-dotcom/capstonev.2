<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin(){
        return view('index');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect users based on their roles
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.managetrip');
                case 'manager':
                    return redirect()->route('manager.deliveryrecords');
                case 'driver':
                    return redirect()->route('driver.deliveryrecords');
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors(['login_error' => 'Invalid username or password']);
    }
}
