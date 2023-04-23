@extends('layouts.app')

@section('content')
    <div class="container">
    <form method="POST" action="{{ route('profiles.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="profile_picture" class="col-form-label">Profile Picture</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture">
                <label class="custom-file-label" for="profile_picture">Choose file</label>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    </div>
@endsection
