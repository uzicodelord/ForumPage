<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\PrivateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('private_messages.index', compact('users'));
    }

    public function show(User $user)
    {
        $messages = PrivateMessage::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())->where('recipient_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)->where('recipient_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('private_messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $message = new PrivateMessage();
        $message->sender_id = Auth::id();
        $message->recipient_id = $user->id;
        $message->content = $request->input('content');
        $message->save();

        $notification = new Notification;
        $notification->message = Auth::user()->name . ' sent you a private message.';
        $notification->user_id = $user->id;
        $notification->private_message_id = $message->id;
        $notification->save();
        $user->increment('notifications_count');

        return redirect()->route('private_messages.show', $user);
    }

}
