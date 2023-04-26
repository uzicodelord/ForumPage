@extends('layouts.app')

@section('content')
    @vite(['resources/js/scroll.js'])

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div style="padding-bottom: 5px;">
                    <a href="{{ route('private_messages.index') }}">
                    <strong><i class="fa fa-arrow-circle-left"></i> Go Back</strong>
                    </a>
                </div>
                <div class="card">
                    <div class="card-header d-flex align-items-center mb-3" style="margin: 10px;">
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle mr-2" width="50" height="50">
                        <div>
                            <a class="font-shadow Novice" href="{{ route('profiles.show', $user->id) }}">
                            <div class="font-weight-bold">{{ $user->name }}</div>
                            </a>
                            <div class="text-muted"><span class="user-rank {{ $user->getRank() }}">[{{$user->getRank()}}]</span></div>
                        </div>

                    </div>
                    <div class="card-body card-height">
                        @if(count($messages) == 0)
                            <p>Start a chat with {{ $user->name }}!</p>
                        @else
                            <ul style="padding-left: 0;">
                                @foreach($messages as $message)
                                    <li style="list-style-type: none; display: flex; align-items: center; {{ $message->sender_id == auth()->id() ? 'justify-content: flex-end;' : '' }}">
                                        @if($message->sender_id != auth()->id())
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle mr-2" width="40" height="40">
                                        @endif
                                        <div style="max-width: 70%; border-radius: 10px; padding: 3px; {{ $message->sender_id == auth()->id() ? 'margin-left: 10px;' : 'margin-right: 10px;' }}">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                @if($message->sender_id != auth()->id())
                                                    <a href="{{ route('profiles.show', $user->id) }}">
                                                        <strong class="user-rank {{ $message->sender->getRank() }}">{{ $message->sender->name }}</strong>
                                                    </a>
                                                    <span class="text-muted mr-2" style="margin-left: 10px;">{{ $message->created_at->diffForHumans() }}</span>
                                                @endif
                                                <div style="display: flex; align-items: center;">
                                                    @if($message->sender_id == auth()->id())
                                                            <strong class="user-rank {{ $message->sender->getRank() }}">{{ $message->sender->name }}</strong>
                                                        <span class="text-muted mr-2" style="margin-left: 10px;">{{ $message->created_at->diffForHumans() }}</span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div style="margin-top: 5px;">{{ $message->content }}</div>
                                        </div>
                                        @if($message->sender_id == auth()->id())
                                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}'s Profile Picture" class="rounded-circle ml-2" width="40" height="40">
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="card-footer">
                        <form method="POST" action="{{ route('private_messages.store', $user->id) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" placeholder="Type your message here" ></textarea>
                            </div>
                            <div class="form-group" style="padding-top: 5px;">
                                <button type="submit" class="btn btn-primary" style="float: right;">Send</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection


