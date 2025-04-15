<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home' => 'Profile']
        ];

        $page = (object) [
            'title' => 'User Profile',
        ];

        $activeMenu = '';

        $user = auth()->user();

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }

    public function edit_picture()
    {
        $user = auth()->user();
        return view('profile.edit_picture', [
            'user' => $user
        ]);
    }

    public function update_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user(); // Ensure this returns the authenticated user

        // Delete old profile picture if it exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Save the new profile picture
        $fileName = "user_" . $user->id . "." . $request->file('profile_picture')->getClientOriginalExtension();
        $filePath = $request->file('profile_picture')->storeAs('profile_pictures', $fileName, 'public');

        // Update the user's profile picture path
        $user->profile_picture = $filePath;
        $user->save(); // Ensure $user is an Eloquent model

        return response()->json(['message' => 'Profile picture updated successfully']);
    }
}
