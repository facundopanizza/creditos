@extends('layouts.app')

@section('title', 'Crear Cliente')

@section('main')
    <div class="card">
        <div class="card-header">
            Editar Cliente
        </div>
        <div class="card-body">
            <form method="POST" action="/clients/{{ $client->id }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first_name">Nombre</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Juan" value="{{ $client->first_name }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Perez" value="{{ $client->last_name }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="phone">Numbero de Telefono</label>
                        <input type="text" class="form-control" name="phone" placeholder="12345678" value="{{ $client->phone }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cell_phone">Numero de Celular</label>
                        <input type="text" class="form-control" name="cell_phone" placeholder="12345678" value="{{ $client->cell_phone }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="activity">Actividad</label>
                        <input type="text" class="form-control" name="activity" placeholder="Perez" value="{{ $client->activity }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="business_address">Direccion Comercial</label>
                        <input type="text" class="form-control" name="business_address" placeholder="Perez" value="{{ $client->business_address }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="home_address">Dirrecion Personal</label>
                        <input type="text" class="form-control" name="home_address" placeholder="Perez" value="{{ $client->home_address }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" name="dni" placeholder="12345678" value="{{ $client->dni }}" required>
                    </div>
                </div>

                @if(Auth::user()->role === 'admin')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="max_simultaneous_credits">Monto Maximo de Credito</label>
                        <input type="text" class="form-control" name="max_simultaneous_credits" placeholder="12345678" value="{{ $client->max_simultaneous_credits }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="maximum_credit">Monto Maximo de Credito</label>
                        <input type="number" class="form-control" name="maximum_credit" placeholder="12345678" value="{{ $client->maximum_credit }}" required>
                    </div>
                </div>
                @endif
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
        </div>
    </div>
@endsection