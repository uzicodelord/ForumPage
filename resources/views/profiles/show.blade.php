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

                        @if(Auth::user()->role == 'admin')
                            <form method="POST" action="{{ route('profile.updateRank', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <div>
                                    <br>
                                    <label for="rank">Rank:</label>
                                    <select name="rank">
                                        @foreach(['Peasant', 'Novice', 'Expert', 'Pro', 'Veteran', 'Master', 'Grandmaster', 'Generalissimo', 'Supreme Commander', 'Ultimate Overlord'] as $rank)
                                            <option value="{{ $rank }}" @if($user->rank == $rank) selected @endif>{{ $rank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Update Rank</button>
                            </form>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@endsection
