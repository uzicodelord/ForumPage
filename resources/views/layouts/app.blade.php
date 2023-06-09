<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Uzi') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;1,100&display=swap" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/chat.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <div>
                                <input type="text" class="form-control" name="q" id="search" placeholder="Search...">

                                <div id="search-results">
                                </div>
                            </div>
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="btn ok" href="{{ route('categories.create') }}">Add Categories</a>
                            </li>
                        @endif
                            <li class="nav-item">
                            <a class="btn ok" href="{{ route('ranking.index') }}">Ranking</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn ok" href="{{ route('forum.index') }}">Forum</a>
                        </li>
                                <li class="nav-item">
                                    <a class="btn ok" href="{{ route('private_messages.index') }}">
                                    <i class="fa fa-comments" aria-hidden="true" style="font-size: 20px;"></i>
                                    </a>
                                </li>
                        @endauth
                        @auth
                            <div class="dropdown">
                                <a class="nav-link btn ok" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="dropdown-toggle">
                                        <span style="position: relative;">
                                        <i style="font-size: 20px;" class="fa fa-bell" aria-hidden="true"></i>
                                        @if (auth()->user()->notifications_count > 0)
                                                @php
                                                    $unreadCount = auth()->user()->notifications->where('read', false)->count();
                                                @endphp
                                            @if ($unreadCount > 0)
                                        <span class="badge badge-danger" style="position: absolute; top: -10px; right: -10px;background: darkred;color: #fff;font-size: 10px;border-radius: 9999px;">
                                            {{ $unreadCount }}
                                        </span>
                                            @endif
                                        @endif
                                    </span>
                                    </span>
                                    </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">Notifications</h6>
                                    @foreach (auth()->user()->notifications->sortByDesc('created_at')->take(5) as $notification)
                                        <hr>
                                        @if ($notification->private_message_id)
                                            <a class="dropdown-item {{ $notification->read ? 'text-muted' : '' }}" href="{{ route('private_messages.show', $notification->private_message_id) }}">
                                                {!! $notification->message !!}
                                                <span class="small">- {{ $notification->created_at->diffForHumans() }}</span>
                                            </a>
                                        @else
                                            <a class="dropdown-item {{ $notification->read ? 'text-muted' : '' }}" href="{{ route('posts.show', $notification->post_id) }}">
                                                {!! $notification->message !!}
                                                <span class="small">- {{ $notification->created_at->diffForHumans() }}</span>
                                            </a>
                                        @endif
                                        @if (!$notification->read)
                                            <a href="/read-notification/{{ $notification->id }}" class="text-muted float-right"><x-feathericon-eye-off style="float:right;width: 15px;height: 15px;" /></a>
                                        @endif
                                        <a href="/delete-notification/{{ $notification->id }}" class="text-muted float-right mr-2" ><x-feathericon-trash-2 style="float:right;width: 15px;height: 15px;" /></a>
                                    @endforeach
                                    <br>
                                    @if (auth()->user()->notifications_count > 0)
                                    <a href="{{ route('notifications.index') }}" style="font-size: 13px;">Show All...</a>
                                    @else
                                        <h6 class="dropdown-header">No Notifications</h6>
                                    @endif
                                </div>
                            </div>
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                <button type="button" class="btn ok" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    {{ __('Login') }}
                                </button>
                                </li>
                                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="loginModalLabel">{{ __('Login') }}</h5>
                                                <button type="button" class="btn-close sss" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                                        <div class="col-md-6">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6 offset-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                <label class="form-check-label" for="remember">
                                                                    {{ __('Remember Me') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-0">
                                                        <div class="col-md-8 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Login') }}
                                                            </button>

                                                            @if (Route::has('password.request'))
                                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                    {{ __('Forgot Your Password?') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <button type="button" class="btn ok" data-bs-toggle="modal" data-bs-target="#registerModal">
                                        {{ __('Register') }}
                                    </button>
                                </li>
                                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="registerModalLabel">{{ __('Register') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('register') }}">
                                                        @csrf

                                                        <div class="row mb-3">
                                                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                                @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                                @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-0">
                                                            <div class="col-md-6 offset-md-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ __('Register') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle btn ok" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i style="font-size: 20px;" class="fa fa-user-circle" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}'s Profile Picture" class="rounded-circle mr-2" width="30" height="30">
                                        {{ Auth::user()->name }}
                                    </h6>
                                    <a class="dropdown-item" href="{{ route('profiles.show', Auth::user()->id) }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        $(document).ready(function() {
            $('.dropdown-menu').on('click', '.notification-action a', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');
                var action = $(this).find('svg').attr('data-feather');

                if (action === 'eye-off') {
                    $.get(url);
                } else if (action === 'trash-2') {
                    if (confirm('Are you sure you want to delete this notification?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(result) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('search.index') }}",
                    method: "GET",
                    data: {q: query},
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        $.each(data.posts, function(i, post) {
                            html += '<a href="/posts/' + post.id + '">' + post.title + '</a><br>';
                        });
                        $.each(data.categories, function(i, category) {
                            html += '<a href="/categories/' + category.name + '">' + category.name + '</a><br>';
                        });
                        $.each(data.users, function(i, user) {
                            html += '<a href="/profiles/' + user.id + '">' + user.name + '</a><br>';
                        });
                        $('#search-results').html(html);
                    }
                });
            });
        });

    </script>
</body>
</html>
