@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $user->name }}'s Profile</h1>
                        <span class="font-shadow">{{ $user->rank }}</span>
                        <p>Points: {{ $user->points }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Posts: {{ $user->posts->count() }}</p>
                        <p>Replies: {{ $user->replies->count() }}</p>
                        <p>Reaction score: {{ $user->reactions->count() }}</p>
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
