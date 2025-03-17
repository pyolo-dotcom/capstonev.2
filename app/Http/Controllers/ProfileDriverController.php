<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileDriverController extends Controller
{
    /**
     * Display the driver's profile.
     */
    public function showProfileDriver()
    {
        $user = Auth::user();
        return view('driver.profilemanagement', compact('user'));
    }

    /**
     * Update the driver's profile.
     */
    public function updateProfileDriver(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dob' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Prepare data for update
        $data = [
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'dob' => $request->dob,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }
            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        // Update the driver's profile
        $user->update($data);

        return redirect()->route('driver.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the driver's license information.
     */
    public function updateDriverLicense(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'driver_license_number' => 'nullable|string|max:255',
            'license_expiry_date' => 'nullable|date',
            'license_type' => 'nullable|string|max:255',
        ]);

        // Update the driver's license information
        $user->update([
            'driver_license_number' => $request->driver_license_number,
            'license_expiry_date' => $request->license_expiry_date,
            'license_type' => $request->license_type,
        ]);

        return redirect()->route('driver.profile')->with('success', 'Driver\'s license information updated successfully.');
    }

    /**
     * Handle the change password request for the driver.
     */
    public function changePasswordDriver(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The current password is incorrect.',
            ], 422); // 422 is the HTTP status code for validation errors
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}