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
            <a class="navbar-brand" href="/">Creditos</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @guest
            @else
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @if(Auth::user()->role !== 'admin')
                    @else
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Caja
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/initial_cash">Caja Diaria</a>
                            <?php
                                $lastDay = App\InitialCash::all()->last();
                            ?>
                            @if($lastDay !== null && $lastDay->active !== 0)
                                <a class="dropdown-item" href="/close_day">Cerrar Caja Diaria</a>
                            @endif
                            <a class="dropdown-item" href="/cash_entries">Recibir dinero de Vendedor</a>
                            <a class="dropdown-item" href="/closed_days">Ver Cajas Cerradas</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Vendedores
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/users">Lista de Vendedores</a>
                            <a class="dropdown-item" href="/disabled-users">Lista de Vendedores Deshabilitados</a>
                            <a class="dropdown-item" href="/pay-to-users">Pagar Sueldo a Vendedores</a>
                            <a class="dropdown-item" href="/seller_payments">Ver Pagos de Sueldos a Vendedores</a>
                            <a class="dropdown-item" href="/register">Crear</a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Clientes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/clients">Lista de Clientes</a>
                            <a class="dropdown-item" href="/clients/create">Crear</a>
                            @if(Auth::user()->role == 'admin')
                            <a class="dropdown-item" href="/defaults/maximum_credit">Modificar valor default de prestamo maximo</a>
                            @endif
                        </div>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Creditos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/credits">Lista de Creditos</a>
                            <a class="dropdown-item" href="/credits/create">Nuevo Credito</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/consult">
                        Consultar
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/expenses">Gastos Vendedor</a>
                            <a class="dropdown-item" href="/disabled-users">Lista de Vendedores Deshabilitados</a>
                            <a class="dropdown-item">
                                <form method="POST" action="/logout">
                                    @csrf
                                    
                                    <button type="submit" class="" style="padding-left: 0px; background-color: transparent; border: none">Cerrar Sesión</button>
                                </form>
                            </a>
                        </div>
                    </li>
                </ul>
                <div class="nav-item text-light">
                    Saldo: {{ Auth::user()->wallet }}
                </div>
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