@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Forum</h1>
        <p>Welcome to the forum!</p>
         <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">All Posts</div>
                            <div class="card-body">
                                @if (count($posts) > 0)
                                    @foreach ($posts as $post)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h3><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                                            </div>
                                            <div class="card-body">
                                                <small>Written on {{ $post->created_at }} by {{ $post->user->name }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $posts->links() }}
                                @else
                                    <p>No posts found</p>
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
