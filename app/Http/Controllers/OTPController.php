<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OTPController extends Controller
{
    // Send OTP to user
    public function sendOTP(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Check credentials first
        $user = User::where('username', $request->username)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Invalid credentials']);
        }

        // Generate OTP (6 digits)
        $otp = rand(100000, 999999);
        $otp_expires_at = now()->addMinutes(15);

        // Save OTP to user
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otp_expires_at
        ]);

        // Send email with OTP
        Mail::to($user->email)->send(new SendOTP($otp));

        // Store user ID in session for verification
        Session::put('otp_user_id', $user->id);

        return redirect()->route('verify.otp.view');
    }

    // Show OTP verification form
    public function showOTPForm()
    {
        if (!Session::has('otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp-verify');
    }

    // Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = User::find(Session::get('otp_user_id'));

        if (!$user) {
            return redirect()->route('login')->withErrors(['login_error' => 'Session expired']);
        }

        // Check if OTP matches and not expired
        if ($user->otp != $request->otp || now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp_error' => 'Invalid or expired OTP']);
        }

        // Clear OTP fields
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        // Log the user in
        Auth::login($user);

        // Clear session
        Session::forget('otp_user_id');

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.deliveryrecords');
            case 'manager':
                return redirect()->route('manager.deliveryrecords');
            case 'driver':
                return redirect()->route('driver.deliveryrecords');
            default:
                return redirect()->route('home');
        }
    }
}