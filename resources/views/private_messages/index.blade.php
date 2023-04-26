@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Conversations') }}</div>

                    <div class="card-body">
                        <ul>
                            @foreach($users as $user)
                                <div class="d-flex align-items-center mb-3" style="margin: 10px;">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle mr-2" width="50" height="50">
                                    <div>
                                        <a class="font-shadow Novice" style="font-size: 18px;" href="{{ route('private_messages.show', $user->id) }}">
                                            <div class="font-weight-bold">{{ $user->name }}</div>
                                        </a>
                                        <div class="text-muted"><span class="user-rank {{ $user->getRank() }}">[{{$user->getRank()}}]</span></div>
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
