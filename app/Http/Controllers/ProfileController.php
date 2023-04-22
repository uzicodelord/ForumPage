<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('updateRank');
    }

    public function show($id)
    {
        $user = User::find($id);
        $posts = $user->posts;
        return view('profiles.show', ['user' => $user, 'posts' => $posts]);
    }

    public function updateRank(User $user)
    {
        $user->getRank();
        $user->save();

        return redirect()->route('profiles.show', $user->id);
    }


}
