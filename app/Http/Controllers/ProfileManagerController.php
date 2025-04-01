<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileManagerController extends Controller
{
    /**
     * Display the manager's profile.
     */
    public function showProfileManager()
    {
        $user = Auth::user();
        return view('manager.profilemanagement', compact('user'));
    }

    /**
     * Update the manager's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'dob' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_profile_image' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle profile picture removal
        if ($request->remove_profile_image) {
            $this->removeProfileImage($user);
            $user->profile_picture = null;
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $this->removeProfileImage($user);
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update user data
        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'dob' => $request->dob ?: null,
        ]);

        return redirect()->route('manager.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Handle the change password request.
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'The current password field is required.',
            'new_password.required' => 'The new password field is required.',
            'new_password.min' => 'The new password must be at least 8 characters.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
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
    }

    /**
     * Remove the manager's profile image.
     */
    public function removeImage(Request $request)
    {
        $user = Auth::user();
        
        $this->removeProfileImage($user);
        
        $user->profile_picture = null;
        $user->save();
        
        return redirect()->route('manager.profile')->with('success', 'Profile image removed successfully');
    }

    /**
     * Helper method to remove profile image from storage.
     */
    private function removeProfileImage(User $user)
    {
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
            return true;
        }
        return false;
    }
}