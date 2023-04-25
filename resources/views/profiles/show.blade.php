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
                                <div class="d-flex user-rank" style="margin-left: 10px; padding: 5px; border-radius: 5px;">
                                    <p class="user-rank {{ $user->getRank() }}" style="margin-right: 10px;">Points: {{ $user->points }}
                                        <i class="fas fa-bolt"></i>
                                    </p>
                                    <p class="user-rank {{ $user->getRank() }}" style="margin-right: 10px;">Posts: {{ $user->posts->count() }}
                                        <i class="fa fa-clipboard"></i>
                                    </p>
                                    <p class="user-rank {{ $user->getRank() }}" style="margin-right: 10px;">Replies: {{ $user->replies->count() }}
                                        <i class="fa fa-reply" aria-hidden="true"></i>
                                    </p>
                                    <p class="user-rank {{ $user->getRank() }}" style="margin-right: 10px;">Reaction score: {{ $user->reactions->count() }}
                                        <i class="fa fa-smile" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                            <br>
                            @if(Auth::user()->id == $user->id)
                                <a href="{{ route('profiles.edit', $user->id) }}">
                                    <h4 class="btn btn-primary">Edit Profile</h4>
                                </a>
                            @endif
                            <hr>
                            <div class="user-awards">
                                    @foreach ($user->getAwards() as $award)
                                    <span style="padding-bottom: 10px;" class="fa fa-trophy user-rank {{ $user->getRank() }}"> Awards:</span>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="user-rank Legend badge badge-{{ $award->color ?? 'primary' }}">{{ $award->name }}</span>
                                            <span class="badge">{{ $award->description }}</span>
                                        </li>
                                    <hr>
                                    @endforeach
                            </div>
                            <div class="container">
                                <h2>Posts</h2>
                                @if (count($posts) > 0)
                                    @foreach ($posts as $post)
                                        <div class="card mb-3">
                                            <div class="card-header d-flex justify-content-between">
                                                <h3 class="mb-0"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h3>
                                                <div class="d-flex align-items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $post->averageRating)
                                                            <x-bi-star-fill class="text-warning" />
                                                        @else
                                                            <x-bi-star class="text-warning" />
                                                        @endif
                                                    @endfor
                                                    <span class="badge badge-pill badge-secondary mr-2">{{ $post->replies->count() }} replies</span>
                                                    <span class="badge badge-pill badge-secondary">{{ $post->views_count }} views</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <small>Posted on {{ $post->created_at }} by <a href="{{ route('profiles.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                                    <span class="user-rank {{ $post->user->getRank() }}" style="font-size: 15px;">[{{ $post->user->rank }}]</span></small>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $posts->links('vendor.pagination') }}
                                @else
                                    <p>No posts found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
