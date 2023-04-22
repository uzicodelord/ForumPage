@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chat</div>

                    <div class="card-body">
                        <div id="messages">
                            @foreach ($messages as $message)
                                <div>{{ $message->user->name }}: {{ $message->message }}</div>
                            @endforeach
                        </div>

                        <form action="{{ route('chat.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <textarea name="message" class="form-control" placeholder="Type your message here"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
