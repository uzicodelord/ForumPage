<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Post $post, Request $request)
    {
        $reply = new Reply();
        $reply->body = $request->body;
        $reply->user_id = auth()->user()->id;
        $post->replies()->save($reply);

        $user = auth()->user();
        if ($post->user_id !== $user->id) {
            $notification = new Notification;
            $notification->message = $user->name . ' replied to your post.';
            $notification->user_id = $post->user_id;
            $notification->post_id = $post->id;
            $notification->save();
            $post->user->increment('notifications_count');
        }

        $user->points += 5;
        $user->updateRank();
        $user->save();

        return response()->json([
            'body' => $reply->body,
            'created_at' => $reply->created_at->diffForHumans(),
            'user' => [
                'name' => $reply->user->name,
                'profile_url' => route('profiles.show', $reply->user->id),
                'profile_picture_url' => asset('storage/' . $reply->user->profile_picture),
                'rank' => $reply->user->getRank(),
            ],
        ]);
    }


    public function show(Post $post, Reply $reply)
    {
        $usersRank = $reply->user->rank;
        return view('posts.show', compact('post', 'reply', 'usersRank'));
    }

}
