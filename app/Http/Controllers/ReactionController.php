<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:like,love,laugh',
        ]);

        $user = auth()->user();
        $reaction = $post->reactions()->where('user_id', $user->id)->first();

        if ($reaction) {
            if ($reaction->type === $validatedData['type']) {
                $reaction->delete();
            } else {
                $reaction->type = $validatedData['type'];
                $reaction->save();
            }
        } else {
            $reaction = new Reaction;
            $reaction->type = $validatedData['type'];
            $reaction->user_id = $user->id;

            $post->reactions()->save($reaction);
        }

        return back();
    }

    public function destroy(Post $post, Reaction $reaction)
    {
        $this->authorize('delete', $reaction);

        $reaction->delete();

        return back();
    }
}
