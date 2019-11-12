<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Creditos</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @guest
            @else
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @if(Auth::user()->role !== 'admin')
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/initial_cash/create">Iniciar Caja Diaria</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Usuarios
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/users">Lista de Usuarios</a>
                            <a class="dropdown-item" href="/disabled-users">Lista de Usuarios Deshabilitados</a>
                            <a class="dropdown-item" href="/register">Crear</a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Clientes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/clients">Lista de Clientes</a>
                            <a class="dropdown-item" href="/clients/create">Crear</a>
                        </div>
                    </li>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Creditos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/credits">Lista de Creditos</a>
                            <a class="dropdown-item" href="/credits/create">Nuevo Credito</a>
                        </div>
                    </div>
                </ul>
            </div>
            @endguest

            @guest
            @else
            <div class="nav-item text-light">
                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
            </div>
            <div class="nav-item">
                <form method="POST" action="/logout">
                    @csrf
                    
                    <button type="submit" class="nav-link text-light" style="background-color: transparent; border: none">Cerrar Sesión</button>
                </form>
            </div>
            @endguest

        </nav>
        <main class="container">
            @yield('main')
        </main>
    </header>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>