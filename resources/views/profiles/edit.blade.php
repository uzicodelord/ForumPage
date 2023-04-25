@extends('layouts.app')

@section('content')

    <div class="container">
        <form method="POST" action="{{ route('profiles.update.name', $user->id) }}">
            @csrf
            @method('PUT')

            @if(Auth::user()->name_changed_at && Auth::user()->name_changed_at->addWeek()->isFuture())
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" disabled style="background-color: #1b2838">
                    <small class="form-text text-danger">You cannot change your name until {{ Auth::user()->name_changed_at->addWeek()->format('M d, Y') }}</small>
                </div>
            @else
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                    <small class="form-text text-warning">Note: If you change your name now you can't change it for a week.</small>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Save Name</button>
            @endif
        </form>
        <form method="POST" action="{{ route('profiles.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                @if(Auth::user()->email !== $user->email && !$user->hasVerifiedEmail())
                    <div class="text-warning">Please confirm your new email address before saving changes.</div>
                @endif
            </div>

            <div class="form-group">
                <label for="profile_picture" class="col-form-label">Profile Picture</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture">
                    <label class="custom-file-label" for="profile_picture">Choose file</label>
                </div>
            </div>

            <div class="form-group">
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="img-thumbnail" width="200">
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

@endsection
