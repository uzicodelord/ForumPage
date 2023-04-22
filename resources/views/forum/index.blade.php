@extends('layouts.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        var userId = {{ Auth::id() }};
    </script>

    <div class="container">
        <div style="text-align: center;">
            <img src="{{ asset('images/banner.gif') }}" alt="Image" style="width: 30%; margin: 0 auto;">
            <img src="{{ asset('images/banner1.gif') }}" alt="Image" style="width: 40%; margin: 0 auto;">
            <img src="{{ asset('images/banner.gif') }}" alt="Image" style="width: 30%; margin: 0 auto;">
        </div>

        <div class="row">
            <div class="col-md-3">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body">
                    <div id="messages" style="padding-bottom: 5px;">
                        @foreach ($messages as $message)
                            <div style="padding-bottom: 5px;">
                                <a href="{{ route('profiles.show', $message->user->id) }}">{{ $message->user->name }}<span class="font-shadow" style="font-size: 16px;"> {{ $message->user->rank }}:</span></a>
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
                        <!-- Show the special categories in a separate card -->
                        <div class="card">
                            <div class="card-header"><h4>Home</h4></div>
                            <div class="card-body">
                                @if (count($categories) > 0)
                                    <div class="row">
                                        @foreach ($specialCategories as $category)
                                            <div class="mb-3">
                                                <div class="card-header">
                                                    <h3>
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
                        <br>
                        <div class="card">
                            <div class="card-header">All Categories</div>
                            <div class="card-body">
                                @if (count($categories) > 0)
                                    <div class="row">
                                        @foreach ($categories as $category)
                                                <div class="mb-3">
                                                    <div class="card-header">
                                                        <h3>
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
                        <br>
                        <div class="card">
                            <div class="card-header">Recent Posts</div>
                            <div class="card-body">
                                @if (count($posts) > 0)
                                    @foreach ($posts->take(3) as $post)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h3><a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a></h3>
                                            </div>
                                            <div class="card-body">
                                                <small>Posted on {{ $post->created_at }} by <a href="{{ route('profiles.show', $post->user->id) }}">{{ $post->user->name }}</a> <span class="font-shadow spancolor" style="font-size: 15px;">[{{ $post->user->rank }}]</span></small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
@endsection
