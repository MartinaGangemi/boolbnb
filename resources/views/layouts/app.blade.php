<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- tomtom -->
    <link  rel='stylesheet'  type='text/css'  href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps.css'>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img width="100px" src="{{ asset('img/logo.svg')}}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mx-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Admin
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

    <main class="pb-4">
        @yield('content')
    </main>

    <!-- footer -->
    <footer class="bg-dark">
        <div class="container">
        <p class="text-light py-5 mb-0 text-center">Copyright &copy; team6</p>
        </div>
    </footer>



    <script  src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps-web.min.js"></script>
    <script  src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/services/services-web.min.js"></script>


    <script>
        let validate = function() {
            if (document.getElementById('password').value ==
                document.getElementById('password-confirm').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Le password combaciano';
                document.getElementById('submit_button').removeAttribute('disabled')
            } else {
                document.getElementById('submit_button').setAttribute('disabled', 'disabled')
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Le password non combaciano';
            }
        }
    </script>
</body>
</html>
