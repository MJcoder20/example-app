<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Online Reservations') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    
    {{-- <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style> --}}

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        };
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

     <!-- Scripts -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Online Reservations') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    {{-- <ul class="navbar-nav ms-auto">
                        @auth
                        <li>
                            <span class="font-bold uppercase">Welcome {{auth()->user()->name}}</span>
                        </li>
                        <li>
                            <a href="/listings/manage" class="hover:text-laravel"
                                ><i class="fa-solid fa-gear"></i>
                                Manage Users</a
                            >
                        </li>
                        <li>
                            <form class="inline" action="/logout" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-door-closed">Logout</i>
                            </button>
                            </form>
                        </li>

                        @else
                        
                        @endauth
                    </ul> --}}



                     <!-- Right Side Of Navbar -->
                     <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                           
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="hover:text-laravel" href="{{ route('login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i>
                                        {{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="hover:text-laravel" href="{{ route('register') }}">
                                        <i class="fa-solid fa-user-plus"></i> {{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        {{-- <li>
                            <span class="font-bold uppercase">Welcome {{auth()->user()->name}}</span>
                        </li>
                        <li>
                            <a href="/listings/manage" class="hover:text-laravel"
                                ><i class="fa-solid fa-gear"></i>
                                Manage Users</a
                            >
                        </li>
                        <li>
                            <form class="inline" action="/logout" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-door-closed">Logout</i>
                            </button>
                            </form>
                        </li> --}}

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
    {{$slot}}
  </main>
    

    <footer
    class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
    <p class="ml-2">Copyright &copy; 2023, All Rights reserved</p>

    <a href="/users/create"
        class="absolute top-1/3 right-10 bg-black text-white py-2 px-5">Create User</a>
</footer>
</body>
</html>