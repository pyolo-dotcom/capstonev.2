<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileDriverController extends Controller
{
    /**
     * Display the driver's profile.
     */
    public function showProfileDriver()
    {
        $user = Auth::user()->load('truck');
        return view('driver.profilemanagement', compact('user'));
    }

    /**
     * Update the driver's profile (AJAX version).
     */
    public function updateProfileDriver(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'dob' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_profile_image' => 'nullable|boolean'
        ], [
            'profile_picture.image' => 'The profile picture must be an image',
            'profile_picture.mimes' => 'The profile picture must be a JPEG, PNG, JPG, or GIF file',
            'profile_picture.max' => 'The profile picture may not be larger than 2MB',
            'username.required' => 'Username is required',
            'fullname.required' => 'Full name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [
                'username' => $request->username,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'dob' => $request->dob ?: null
            ];

            // Handle profile picture removal
            if ($request->remove_profile_image) {
                if ($this->removeProfileImage($user)) {
                    $updateData['profile_picture'] = null;
                }
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $this->removeProfileImage($user);
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $updateData['profile_picture'] = $path;
            }

            // Update user data
            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user->fresh()
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile update error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the driver's license information.
     */
    public function updateDriverLicense(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'driver_license_number' => 'required|string|max:255',
            'license_expiry_date' => 'required|date|after:today',
            'license_type' => 'required|string|max:255',
        ], [
            'license_expiry_date.after' => 'License expiry date must be in the future'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        try {
            $user->update([
                'driver_license_number' => $request->driver_license_number,
                'license_expiry_date' => $request->license_expiry_date,
                'license_type' => $request->license_type,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Driver license updated successfully!',
                'user' => $user->fresh()
            ]);

        } catch (\Exception $e) {
            \Log::error('License update error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update license: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle the change password request.
     */
    public function changePasswordDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Current password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.confirmed' => 'Password confirmation does not match'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        try {
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect',
                    'errors' => [
                        'current_password' => ['The current password is incorrect.']
                    ]
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Password change error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to remove profile image from storage.
     */
    private function removeProfileImage(User $user)
    {
        try {
            if ($user->profile_picture) {
                if (Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to remove profile image: '.$e->getMessage());
            return false;
        }
    }
}