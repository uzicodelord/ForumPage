<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        return view('forum.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $message = new Message();
        $message->user_id = Auth::id();
        $message->message = $request->input('message');
        $message->save();
        $message->load('user');

        return response()->json($message);
    }


}
