<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Send OTP to email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        // Generate OTP (6 digits)
        $otp = rand(100000, 999999);
        $token = Str::random(60);

        // Save OTP to database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // Send email with OTP
        Mail::to($user->email)->send(new PasswordResetMail($otp));

        return redirect()->route('password.reset', $token)
            ->with('status', 'We have emailed your OTP code!');
    }

    // Show reset password form
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'otp' => 'required|digits:6',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $resetData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Invalid token or email']);
        }

        if ($resetData->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP code']);
        }

        // Check if OTP is expired (15 minutes)
        if (Carbon::parse($resetData->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['otp' => 'OTP has expired']);
        }

        // Update password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete the reset record
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }
}