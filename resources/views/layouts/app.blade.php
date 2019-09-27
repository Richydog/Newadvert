<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Advert') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="public/fonts/fontawesome/css/all.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>
<div class="container-fluid">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Advert') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                 <h5>Личный кабинет</h5>   {{  Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('admin-panel')
                                    <a class="dropdown-item" href="{{ route('admin.home') }}">Admin</a>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">User</a>
                                    <a class="dropdown-item" href="{{ route('users.create') }}">Create User</a>
                                        <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                                    @endcan
                                        <a class="dropdown-item" href="{{ route('profilyhome') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('home') }}">Cabinet</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"

                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @section('search')
            <div class="search-bar pt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <form action="{{ route('adverts.index.all') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="text" value="{{ request('text') }}" placeholder="Search for...">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button class="btn btn-light border" type="submit"><span class="fa fa-search"></span></button>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <p><a href="{{ route('adverts.create') }}" class="btn btn-success"><span class="fa fa-plus"></span> Add New Advertisement</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @show
        <main class="py-4">
            @include('layouts.partials.flash')
            @yield('content')
        </main>
    </div>
</div>
<footer>
    <div class="container">
        <div class="border-top pt-3">
            <p>&copy; {{ date('Y') }} - Adverts</p>
        </div>
    </div>
</footer>

<!-- Scripts -->

<script src="{{ asset('public/js/app.js') }}"></script>

</body>
</html>
