@extends('layouts.app')
@section('content')
    @auth
    <div class="container">
    <h1>
        <a href="{{ route('forum.index') }}">Forum</a>
    </h1>
    </div>
    @endauth
    @guest
    <div class="container col-2">
        <h1>
            <a href="{{ route('login') }}">Login</a>
            or
            <a href="{{ route('login') }}">Register</a>
        </h1>
        <h3>to view the Forum</h3>
    </div>
    @endguest
@endsection
