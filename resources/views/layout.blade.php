<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    {{-- Requires npm install and npm run dev --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"> 
    <title>
        @yield('mtitle')
    </title>
</head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{ route('home') }}">Home</a>
            <a class="p-2 text-dark" href="{{ route('posts.index') }}">Posts</a>
            <a class="p-2 text-dark" href="{{ route('posts.create') }}">Add Post</a>
            
            @guest
                @if (Route::has('register'))
                    <a class="p-2 text-dark" href="{{ route('register') }}">Register</a>
                @endif
                <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>
            @else
                <a class="p-2 text-dark" 
                    href="{{ route('users.show', ['user' => Auth::user()->id]) }}">
                    Profile
                </a>
                {{-- <a class="p-2 text-dark" 
                    href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">
                    {{ __('Edit Profile') }}
                </a> --}}

                <a class="p-2 text-dark" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout ({{ Auth::user()->name }})
                </a>

                <form id="logout-form" action={{ route('logout') }} method="POST"
                    style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>

    <div class="container">
        {{-- FLASH MESSAGE --}}
        @if(session()->has('status'))
            <p style="color: green">
                {{ session()->get('status') }}
            </p>
        @endif

        @yield('content')
    </div>

    {{-- Requires npm install and npm run dev --}}
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
</body>
</html>