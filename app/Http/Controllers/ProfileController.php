<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::find($id);
        $posts = $user->posts;
        return view('profiles.show', ['user' => $user, 'posts' => $posts]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('profiles.edit', compact('user'));
    }

    protected function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $oldProfilePicture = $user->profile_picture;

            if ($oldProfilePicture !== 'profile_picture/default.png') {
                Storage::disk('public')->delete($oldProfilePicture);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_picture', 'public');

            // If the uploaded file is the default.png file, don't delete it
            if ($profilePicturePath === 'profile_picture/default.png') {
                $user->profile_picture = $profilePicturePath;
            } else {
                $user->profile_picture = $profilePicturePath;
            }

            $user->save();
        }

        return redirect()->route('profiles.show', $user->id);
    }

}
