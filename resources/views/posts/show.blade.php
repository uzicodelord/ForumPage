@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b style="color: #fff;">
                            <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="{{ $post->user->name }}'s Profile Picture" class="rounded-circle mr-2" width="50" height="50">
                            <a href="{{ route('profiles.show', $post->user->id) }}">{{ $post->user->name }}</a>
                            <span class="user-rank {{ $post->user->getRank() }}">[{{ $post->user->rank }}]</span>
                        </b>
                    </div>
                    <div class="card-body">
                        <strong style="color: #fff">
                        {!! $post->title !!}
                        </strong>
                    </div>
                    <div class="card-body">
                        @if(Auth::id() !== $post->user_id && (!$post->reactions()->where('user_id', Auth::id())->exists() || !$post->replies()->where('user_id', Auth::id())->exists()))
                            <h6 style="color: darkred;width: 100%;" class="user-rahk Overlord">
                                To see this hidden content, you must reply and react.
                            </h6>
                        @else
                            {{ $post->content }}
                        @endif
                    </div>
                @if($post->reactions()->count() > 0)
                        <div class="reactions" style="margin: 10px;">
                            @php
                                $reactions = $post->reactions->groupBy('type')->map(function($reaction) {
                                    return $reaction->count();
                                });
                            @endphp
                            @if($reactions->has('like'))
                                <span class="reaction-icon">&#x1F44D; {{ $reactions['like'] }}</span>
                            @endif
                            @if($reactions->has('love'))
                                <span class="reaction-icon">&#x2764;&#xFE0F; {{ $reactions['love'] }}</span>
                            @endif
                            @if($reactions->has('laugh'))
                                <span class="reaction-icon">&#x1F602; {{ $reactions['laugh'] }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="card-footer">
                        <p>React to this post:</p>
                        <form action="{{ route('reactions.store', $post) }}" method="POST" class="d-flex">
                            @csrf
                            <div class="form-group mr-3" style="padding-right: 10px;">
                                <select class="form-control" name="type" id="type">
                                    <option value="like">&#x1F44D;</option>
                                    <option value="love">&#x2764;&#xFE0F;</option>
                                    <option value="laugh">&#x1F602;</option>
                                </select>
                            </div>
                            @if($post->reactions()->where('user_id', auth()->id())->exists())
                                <button type="submit" class="btn btn-primary flex-shrink-0">Unreact</button>
                            @else
                                <button type="submit" class="btn btn-primary flex-shrink-0">React</button>
                            @endif
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="votes d-flex align-items-center">
                            <form action="{{ route('posts.vote', $post) }}" method="POST" class="px-2">
                                @csrf
                                <button type="submit" name="vote" value="upvote" class="btn btn-primary mr-2">Upvote</button>
                                <span style="padding-left: 5px;">{{ $post->upvotes }}</span>
                                <hr>
                                <button type="submit" name="vote" value="downvote" class="btn btn-danger sh mr-2">Downvote</button>
                                <span style="padding-left: 5px;">{{ $post->downvotes }}</span>
                            </form>
                            <div class="flex-grow-1">
                                <span class="user-rank Grandmaster">{{ $post->upvotes + $post->downvotes }} votes</span>
                            </div>
                            <div class="" style="font-size: 14px;">
                                <span class="user-rank Divine">Rating: {{ $post->averageRating }} </span>
                                <br>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $post->averageRating)
                                        <i class="fas fa-star text-warning user-rank Master"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="card-header">
                        <hr>
                            {{ $post->replies->count() }} Replies
                        </div>
                        <div class="card-body">
                            @foreach ($post->replies as $reply)
                                <div class="mb-3">
                                    <div class="font-weight-bold"><b style="color: #fff">{{ $reply->user->name }} <span class="user-rank {{ $reply->user->getRank() }}">[{{ $reply->user->getRank() }}]</span></b></div>
                                    <div>{{ $reply->body }}
                                        <span class="text-muted" style="float:right;">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach

                            <form method="POST" action="{{ route('replies.store', $post) }}">
                                @csrf

                                <div class="form-group">
                                    <label for="replyBody">Leave a reply</label>
                                    <textarea name="body" id="replyBody" class="form-control" rows="5"></textarea>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                                <div class="pagination-wrapper" style="background-color: #090909; color: darkred; text-align: center;">
                                    {{ $replies->links('vendor.pagination') }}
                                </div>
                        </div>
                    </div>
                </div>

            @if($post->user_id == Auth::id())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Actions</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editPostModal">Edit</button>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block mt-2 sh">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Edit Post Modal -->

    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('posts.update', $post) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-post-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit-post-title" name="title"
                                   value="{{ $post->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="edit-post-content" class="form-label">Content</label>
                            <textarea class="form-control" id="edit-post-content" name="content" rows="5">{{ $post->content }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondaryy" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
