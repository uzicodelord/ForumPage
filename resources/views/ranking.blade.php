@extends('layouts.app')
@section('content')
    <div class="container">
    <div class="card">
        <h1 class="card-header">Ranking</h1>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Rank</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->rank }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
