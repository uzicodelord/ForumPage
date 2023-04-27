@extends('layouts.app')
@section('content')
<div style="background-color: #1b2838;font-size: 12px;">
<h6>Search Results for "{{ $query }}"</h6>
@foreach ($posts as $post)
        <li style="font-size: 20px;list-style-type: none;"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></li>
@endforeach
    @foreach($categories as $category)
        <li style="font-size: 16px;"><a href="{{ route('categories.index', str_replace(' ', '-', strtolower($category->name))) }}">{{ $category->name }}</a></li>
    @endforeach
</div>
@endsection
