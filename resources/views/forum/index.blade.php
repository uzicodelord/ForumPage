@extends('layouts.app')

@section('content')
    @vite(['resources/js/scroll1.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        var userId = {{ Auth::id() }};
    </script>
    @if(Auth::check() && !Auth::user()->hasVerifiedEmail())
        <div class="text-center my-2">
            <span class="text-danger mr-2">Please verify your email address.</span>
            &nbsp
            <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-primary">Verify Email</a>
        </div>
    @endif
    <div style="margin: 20px;">
        <div style="text-align: center;">
            <img src="{{ asset('images/banner.gif') }}" alt="Image" style="width: 30%; margin: 0 auto;">
            <img src="{{ asset('images/banner1.gif') }}" alt="Image" style="width: 40%; margin: 0 auto;">
            <img src="{{ asset('images/banner.gif') }}" alt="Image" style="width: 30%; margin: 0 auto;">
        </div>

        <div class="image-grid">
            <img src="{{ asset('images/banner-900x120.gif') }}" alt="Image">
            <img src="{{ asset('images/PmxLTLb.gif') }}" alt="Image">
            <img src="{{ asset('images/tirUVXb.gif') }}" alt="Image">
            <img src="{{ asset('images/dcshop-900x120.gif') }}" alt="Image">
            <img src="{{ asset('images/qTRXZC4.gif') }}" alt="Image">
            <img src="{{ asset('images/3HgVqHL.gif') }}" alt="Image">
        </div>

        <br>
        <br>
        <div>
            @if($upvotedpost)
                <h2>Top Voted Post</h2>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3><a href="{{ route('posts.show',$upvotedpost->id) }}">{{ $upvotedpost->title }}</a></h3>
                    </div>
                    <div class="card-body">
                        <small>Posted on {{ $upvotedpost->created_at }} by <a href="{{ route('profiles.show', $upvotedpost->user->id) }}">{{ $upvotedpost->user->name }}</a>
                            <span class="user-rank {{ $upvotedpost->user->getRank() }}">&nbsp[{{ $upvotedpost->user->rank }}]</span>
                        </small>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-3">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body card-chat-height">
                    <div id="messages" style="padding-bottom: 5px;">
                        @foreach ($messages as $message)
                            <div style="padding-bottom: 5px;">
                                <a href="{{ route('profiles.show', $message->user->id) }}">{{ $message->user->name }}
                                    <span class="user-rank {{ $message->user->getRank() }}">[{{ $message->user->rank }}]:</span>
                                </a>
                                {{ $message->message }}
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <form id="chat-form" style="display: flex;">
                        <input type="text" class="btn btn-primary" id="chat-message" name="message" placeholder="Chat..." style="flex: 1;width: 50%;cursor: text;text-align: left;">
                        <button class="btn btn-primary" type="submit" style="margin-left: 5px;">Send</button>
                    </form>
                </div>
                    </div>
                    </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">Home</div>
                                <div class="card-body">
                                    @if (count($categories) > 0)
                                        <div class="row">
                                            @foreach ($specialCategories as $category)
                                                <div class="mb-3">
                                                    <div class="card-header d-flex align-items-center">
                                                        <i class="fa {{ $categoryIcons[$category->name] }} fa-fw mr-2 user-rank Novice" style="font-size: 30px;"></i>
                                                        <h3 class="font-shadow Novice" style="margin-left: 10px;">
                                                            <a href="{{ route('categories.index', str_replace(' ', '-', strtolower($category->name))) }}">{{ $category->name }}</a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No categories found</p>
                                    @endif
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header">All Categories</div>
                            <div class="card-body">
                                @if (count($categories) > 0)
                                    <div class="row">
                                        @foreach ($categories as $category)
                                                <div class="mb-3">
                                                    <div class="card-header">
                                                        <h3 class="Novice font-shadow">
                                                            {{ $category->posts->count() }}
                                                            <a href="{{ route('categories.index', str_replace(' ', '-', strtolower($category->name))) }}">{{ $category->name }}</a>
                                                        </h3>
                                                    </div>
                                            </div>
                                        @endforeach

                                    </div>
                                @else
                                    <p>No categories found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Actions</div>
                            <div class="card-body">
                                <a href="#" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#createPostModal">Create New Post</a>
                            </div>
                            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('posts.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="body">Body</label>
                                                    <textarea name="content" id="content" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                                    @error('content')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="category">Category:</label>
                                                    <select name="category_id" id="category" class="form-control">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondaryy" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header">Recent Posts</div>
                            <div class="card-body card-recent-height">
                                @if (count($posts) > 0)
                                    @foreach ($posts->take(5) as $post)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h3><a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a></h3>
                                            </div>
                                            <div class="card-body">
                                                <small>Posted on {{ $post->created_at }} by <a href="{{ route('profiles.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                                    <span class="user-rank {{ $post->user->getRank() }}">&nbsp[{{ $post->user->rank }}]</span>
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-header">About Us</div>
                    <div class="card-body">
                        <p style="font-size: 21px;">Join <span class="user-rank Overlord">UziForum</span> to learn about making money on the Internet, IT issues, and much more. Register now to become part of our community and receive help from experienced members.</p>                            </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-header">A Responsibility</div>
                    <div class="card-body">
                        <p style="font-size: 21px;"> <span class="user-rank Overlord">Administration</span> does not bear any responsibility for publications on this forum. If you think that topics and messages may contain information prohibited for distribution, please report.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>

@endsection
