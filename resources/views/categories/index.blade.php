@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header font-shadow" style="font-size: 25px;">{{ $category->name }}</div>
                    <div class="card-body">
                        @if (count($posts) > 0)
                            @foreach ($posts as $post)
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3 class="mb-0"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h3>
                                        <div class="d-flex align-items-center">
                                            <div style="margin-right: 15px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $post->averageRating)
                                                        <i class="fas fa-star text-warning user-rank Master"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="badge badge-pill badge-secondary mr-2">{{ $post->upvotes + $post->downvotes }} votes</span>
                                            <span class="badge badge-pill badge-secondary mr-2">{{ $post->replies->count() }} replies</span>
                                            <span class="badge badge-pill badge-secondary">{{ $post->views_count }} views</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <small>Posted on {{ $post->created_at }} by <a href="{{ route('profiles.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                            <span class="user-rank {{ $post->user->getRank() }}" style="font-size: 15px;">&nbsp[{{ $post->user->rank }}]</span></small>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pagination-wrapper" style="background-color: #090909; color: darkred; text-align: center;">
                                {{ $posts->links('vendor.pagination') }}
                            </div>
                        @else
                            <p>No posts found</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">Actions</div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#createPostModal">Create New Post</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="col-md-4">
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
@endsection
