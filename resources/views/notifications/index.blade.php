@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Notifications</h1>

        @if ($notifications->count() > 0)
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <br>
                    <li class="list-group-item" style="background-color: #1b2838;border: 2px solid #0c8ddb;color: #fff;">
                        {{ $notification->message }}
                        <br>
                        <a href="{{ $notification->private_message_id ? route('private_messages.show', $notification->private_message_id) : route('posts.show', $notification->post_id)}}">View {{ $notification->private_message_id ? 'message' : 'post' }}</a>
                        <br>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
            <br>
        @else
            <p>No notifications.</p>
        @endif
    </div>
@endsection
