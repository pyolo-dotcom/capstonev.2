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

        // Store credentials in session for potential resend
        Session::put('otp_username', $request->username);
        Session::put('otp_password', $request->password);

        // Check credentials first
        $user = User::where('username', $request->username)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Invalid credentials']);
        }

        // Check if user should bypass OTP (remembered device)
        if ($request->has('remember') && $user->otp_verified_at) {
            Auth::login($user, true); // Log in with "remember me"
            return $this->redirectBasedOnRole($user);
        }

        // Generate and send OTP
        $this->generateAndSendOTP($user);

        // Store user ID and remember me in session for verification
        Session::put('otp_user_id', $user->id);
        if ($request->has('remember')) {
            Session::put('otp_remember', true);
        }

        return redirect()->route('verify.otp.view');
    }

    // Resend OTP
    public function resendOTP(Request $request)
    {
        // Get credentials from session
        $username = Session::get('otp_username');
        $password = Session::get('otp_password');

        if (!$username || !$password) {
            return response()->json(['success' => false, 'message' => 'Session expired'], 400);
        }

        // Verify credentials again
        $user = User::where('username', $username)->first();

        if (!$user || !\Hash::check($password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 400);
        }

        // Generate and send new OTP
        $this->generateAndSendOTP($user);

        return response()->json(['success' => true, 'message' => 'New OTP sent']);
    }

    // Helper method to generate and send OTP
    protected function generateAndSendOTP($user)
    {
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

        $user = User::where('id', Session::get('otp_user_id'))->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['login_error' => 'Session expired']);
        }

        // Check if OTP matches and not expired
        if ($user->otp != $request->otp || now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp_error' => 'Invalid or expired OTP']);
        }

        // Clear OTP fields and mark as verified
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'otp_verified_at' => now()
        ]);

        // Log the user in with remember me if set
        $remember = Session::get('otp_remember', false);
        Auth::login($user, $remember);

        // Clear session
        Session::forget(['otp_user_id', 'otp_remember', 'otp_username', 'otp_password']);

        return $this->redirectBasedOnRole($user);
    }

    // Helper method for role-based redirection
    protected function redirectBasedOnRole($user)
    {
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