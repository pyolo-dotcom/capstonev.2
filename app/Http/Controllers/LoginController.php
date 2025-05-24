<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        // Check if user is already logged in with remember token
        if (Auth::viaRemember()) {
            $user = Auth::user();
            return $this->redirectBasedOnRole($user);
        }
        
        return view('index');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Invalid username or password']);
        }

        // Store credentials in session for OTP process
        $request->session()->put('otp_username', $request->username);
        $request->session()->put('otp_password', $request->password);
        
        // Store remember me choice in session
        if ($request->has('remember')) {
            $request->session()->put('otp_remember', true);
        }

        // Redirect to OTP verification
        return redirect()->route('verify.otp.view');
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