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
    public function showProfileManager()
    {
        $user = Auth::user();
        return view('manager.profilemanagement', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'dob' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_profile_image' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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
                $this->removeProfileImage($user);
                $updateData['profile_picture'] = null;
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $this->removeProfileImage($user);
                
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $updateData['profile_picture'] = $path;
            }

            $user->update($updateData);

            return redirect()->route('manager.profile')->with('success', 'Profile updated successfully');

        } catch (\Exception $e) {
            \Log::error('Profile update error: '.$e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update profile: '.$e->getMessage())
                ->withInput();
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

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
    }

    private function removeProfileImage(User $user)
    {
        try {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to remove profile image: '.$e->getMessage());
            return false;
        }
    }
}