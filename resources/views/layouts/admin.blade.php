<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img width="100px" src="{{asset('img/fablo.svg')}}" alt="">
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

        <!-- navbar menu admin -->

        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.apartments.index')}}">
                            Dashboard
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.apartments.create')}}">
                            Create New Post
                        </a>
                    </li> -->

                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
     
    
    function searchAddress() {
    window.axios.defaults.headers.common = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };
    const address = document.getElementById('address').value
    const resultElement = document.querySelector('.results')
    resultElement.innerHTML = ''
    const link = `https://kr-api.tomtom.com/search/2/geocode/${address}.json?key=D4OSGfRW4VAQYImcVowdausckQhvMUbq&typeahead=true`
    axios.get(link).then(response => {
        const addressResults = response.data.results
        //console.log(addressResults);
        addressResults.forEach(item => {
            //console.log(item.address.freeformAddress)
            const listElement = document.createElement('div')
            listElement.innerHTML = `${item.address.freeformAddress}`

            // funzione 
                listElement.addEventListener('click', function() {
                document.getElementById('address').value = item.address.freeformAddress
                const addressForm = document.getElementById('address').value
                resultElement.innerHTML = ''
                resultElement.setAttribute('hidden','true')
//validazione
            })
                const addressValue = document.getElementById('address').value 
                console.log(addressValue)
                console.log(item.address.freeformAddress)
                if( item.address.freeformAddress != addressValue){
                console.log('dati invalidi!')
                } else{
                    console.log('dati corretti')
                }
              resultElement.append(listElement)
             resultElement.removeAttribute('hidden')
             
             console.log(item.address.freeformAddress, 'freeformaddress')
             console.log(addressValue, 'adressvalue')
            
            
        });

    })
   
   
}



</script>
</body>
</html>
