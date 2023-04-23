<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
                $user->points -= 2;
            } else {
                $reaction->type = $validatedData['type'];
                $reaction->save();
            }
        } else {
            $reaction = new Reaction;
            $reaction->type = $validatedData['type'];
            $reaction->user_id = $user->id;

            $post->reactions()->save($reaction);
            $user->points += 2;

            if ($post->user->id !== $user->id) {
                $notification = new Notification;
                $notification->message = $user->name . ' reacted to your post.';
                $notification->user_id = $post->user->id;
                $notification->post_id = $post->id;
                $notification->save();
                $post->user->increment('notifications_count');
            }
        }
        
        $user->updateRank();
        $user->save();

        return back();
    }




    public function destroy(Post $post, Reaction $reaction)
    {
        $this->authorize('delete', $reaction);

        $reaction->delete();

        return back();
    }
}
