<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PixelTagged</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div class="app{{isset($context) ? " $context" : ''}}">
        <header class="navbar navbar-toggleable navbar-light bg-faded">
            <nav class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/">PixelTagged</a>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        @if (Auth::guest())
                            <li class="nav-item">
                                <a class="nav-link {{isset($selected_page) && $selected_page === 'login' ? 'active' : ''}}" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{isset($selected_page) && $selected_page === 'register' ? 'active' : ''}}" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </header>
        @yield('content')
    </div>
    <footer class="footer">
        <div class="container">
            <ul>
                <li>
                    <a href="/about">About</a>
                </li>
            </ul>
        </div>
    </footer>
    @if (isset($dataBootstrap))
    <script id="{!! $dataBootstrap['name'] !!}-data-bootstrap">
        var {!! $dataBootstrap['name'] !!} = {!! json_encode($dataBootstrap['data']) !!};
    </script>
    @endif
    <script src="{{ asset('js/vendor.js') }}"></script>
    @if (isset($context) && file_exists( public_path() . '/js/' . $context . '.js' ))
        <script src="{{ asset(sprintf('js/%s.js', $context)) }}"></script>
    @endif
</body>
</html>
