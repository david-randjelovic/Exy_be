<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        $user->profile_picture_url = $path;
        $user->save();

        return response()->json(['message' => 'Profile picture uploaded successfully.']);
    }

    public function getUserData(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'preferred_language' => $user->preferred_language,
            'currency' => $user->currency,
            'profile_picture_url' => $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : null,
        ]);
    }

    public function updateUserData(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'preferred_language' => 'sometimes|nullable|string|max:255',
            'currency' => 'sometimes|nullable|string|max:10',
        ]);

        $user = $request->user();

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('preferred_language')) {
            $user->preferred_language = $request->input('preferred_language');
        }

        if ($request->has('currency')) {
            $user->currency = $request->input('currency');
        }

        $user->save();

        return response()->json($user);
    }

}
