<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // ✅ Import User Model
use Illuminate\Support\Facades\Auth; // ✅ Import Auth
use Illuminate\Support\Facades\Hash; // ✅ Import Hash

class AuthController extends Controller
{
    // ✅ Login Function
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login_error' => 'The provided credentials are incorrect.',
        ]);
    }

    // ✅ Logout Function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ✅ Register Function
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users',
            'dob' => 'required|date',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'dob' => $request->dob,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // $user = User::create($request->all());

        // $dd($user->toArray());

        return redirect()->route('admin.activeaccount');
    }

}
