<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::find($id);
        $posts = $user->posts()->paginate(5);
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

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $emailExists = User::where('email', $request->input('email'))->where('id', '!=', $user->id)->exists();
        if ($emailExists) {
            return redirect()->back()->with('error', 'Sorry, this email is already taken. Please choose a different email.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()->back()->with('warning', 'Please confirm your email address to update your email.');
        }

        $user->email = $request->input('email');

        $user->save();

        if ($request->hasFile('profile_picture')) {
            $oldProfilePicture = $user->profile_picture;

            if ($oldProfilePicture !== 'profile_picture/default.png') {
                Storage::disk('public')->delete($oldProfilePicture);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_picture', 'public');

            $user->profile_picture = $profilePicturePath;

            $user->save();
        }

        return redirect()->route('profiles.show', $user->id);
    }


    public function updateName(Request $request, User $user)
    {
        if ($user->name_changed_at !== null && $user->name_changed_at->addWeek()->isFuture()) {
            return redirect()->back()->with('error', 'Sorry, you cannot change your name again yet. Please try again later.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
        ]);

        $nameExists = User::where('name', $request->input('name'))->where('id', '!=', $user->id)->exists();
        if ($nameExists) {
            return redirect()->back()->with('error', 'Sorry, this name is already taken. Please choose a different name.');
        }

        $user->name = $request->input('name');

        $user->name_changed_at = now();
        $user->next_name_change_at = now()->addWeek();

        $user->save();

        return redirect()->route('profiles.show', $user->id)->with('success', 'Your name has been updated successfully!');
    }


}
