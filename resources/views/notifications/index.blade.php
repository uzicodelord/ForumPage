@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Notifications</h1>

        @if ($notifications->count() > 0)
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <br>
                    <li class="list-group-item" style="background-color: #090909;border: 2px solid darkred;color: darkred;">
                        {{ $notification->message }}
                        <a href="{{ route('posts.show', $notification->post_id)}}">View post</a>
                        <br>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
            <br>
            {{ $notifications->links('vendor.pagination') }}
        @else
            <p>No notifications.</p>
        @endif
    </div>
@endsection
