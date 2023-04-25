@extends('layouts.app')
@section('content')
    <div class="container">
    <div class="card">
        <h1 class="card-header">Ranking</h1>
        <table>
            <thead>
            <tr>
                <th>Users</th>
                <th>Rank</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>

                    <td class="Grandmaster">

                        <a href="{{ route('profiles.show', $user->id) }}">{{ $user->name }}</a>
                        <hr>
                    </td>

                    <td class="user-rank {{ $user->getRank() }}">{{ $user->getRank() }}<hr></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
