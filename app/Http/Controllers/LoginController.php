<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        // Just validate credentials here, OTP will handle login
        $user = User::where('username', $request->username)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Invalid username or password']);
        }

        // Store credentials in session for OTP process
        $request->session()->put('otp_username', $request->username);
        $request->session()->put('otp_password', $request->password);

        // Redirect to OTP verification
        return redirect()->route('verify.otp.view');
    }
}