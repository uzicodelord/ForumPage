<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required',
        ]);

        $reply = $post->replies()->create([
            'user_id' => auth()->id(),
            'body' => $validatedData['body'],
        ]);

        return back()->with('success', 'Reply added successfully.');
    }

}
