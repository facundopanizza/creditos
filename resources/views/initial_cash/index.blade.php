@extends('layouts.app')

@section('title', 'Inicio de Caja')

@section('main')
    <div class="card">
        @empty($initialCash)
        <div class="card-header">
            Inicio de Caja
        </div>
        <div class="card-body">
            <form method="POST" action="/initial_cash">
                @csrf

                <div class="form-group">
                    <label for="entry_money">Dinero Inicial</label>
                    <input type="number" class="form-control" name="entry_money" required>
                </div>

                <button type="submit" class="btn btn-primary">Crear Inicio de Caja</button>
            </form>
        </div>
        @else
            <div class="card-header">
                Asignar Plata
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        Caja Diaria: {{ $initialCash->entry_money }}
                    </div>
                    <div class="col-md-3">
                        Saldo disponible: {{ $initialCash->money }}
                    </div>
                    <div class="col-md-3">
                        <a href="/expenses_box" class="btn btn-primary">Gastos</a>
                    </div>
                    <div class="col-md-3">
                        <a href="/add_money" class="btn btn-primary">Agregar Plata a Caja</a>
                    </div>
                </div>

                <hr>

                <h4>Asignar Plata a Vendedores</h4>

                <form class="mb-4" method="POST" action="/search/sellers">
                    @csrf

                    <div class="form-group">
                        <label for="first_name">Nombre</label>
                        <input name="first_name" type="text" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <form class="mb-4" method="POST" action="/search/sellers">
                    @csrf

                    <div class="form-group">
                        <label for="last_name">Apellido</label>
                        <input name="last_name" type="text" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <form class="mb-4" method="POST" action="/search/sellers">
                    @csrf

                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input name="dni" type="number" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        @endif
    </div>
@endsection