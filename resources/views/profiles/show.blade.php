@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
                <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div style="position: relative;">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle mr-2" width="50" height="50">
                                    @if(Auth::user()->id == $user->id)
                                        <a href="{{ route('profiles.edit', $user->id) }}" style="position: absolute; top: -5px; left: -5px; background-color: #007bff; color: #fff; width: 25px; height: 25px; border-radius: 50%; text-align: center; font-size: 16px; font-weight: bold;">
                                            +
                                        </a>
                                    @endif
                                </div>
                                <div style="padding-left: 10px;">
                                    <h4>{{ $user->name }}
                                        <span class="user-rank {{ $user->getRank() }}">[{{ $user->rank }}]</span>
                                    </h4>
                                    <p class="m-0">{{ $user->email }}</p>
                                </div>
                                <div class="d-flex user-stats" style="margin-left: 10px;">
                                    <p class="user-stat">Points: {{ $user->points }}</p>
                                    <p class="user-stat">Posts: {{ $user->posts->count() }}</p>
                                    <p class="user-stat">Replies: {{ $user->replies->count() }}</p>
                                    <p class="user-stat">Reaction score: {{ $user->reactions->count() }}</p>
                                </div>
                            </div>
                            <div class="user-awards">
                                <h4>Awards:</h4>
                                    @foreach ($user->getAwards() as $award)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="user-rank Legend badge badge-{{ $award->color ?? 'primary' }}">{{ $award->name }}</span>
                                            <span class="badge">{{ $award->description }}</span>
                                        </li>
                                    <hr>
                                    @endforeach
                            </div>

                            <h2>Posts</h2>
                        @if ($posts->count())
                            @foreach ($posts as $post)
                                <br>
                                <div class="card">
                                    <div class="card-header">
                                        <a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a>
                                    </div>
                                    <div class="card-body">
                                        {{ $post->content }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No posts yet.</p>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@endsection
