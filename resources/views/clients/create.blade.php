@extends('layouts.app')

@section('title', 'Crear Cliente')

@section('main')
    <div class="card">
        <div class="card-header">
            Nuevo Cliente
        </div>
        <div class="card-body">
            <form method="POST" action="/clients">
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first_name">Nombre</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Juan" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Perez" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="phone">Numbero de Telefono</label>
                        <input type="text" class="form-control" name="phone" placeholder="12345678" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cell_phone">Numero de Celular</label>
                        <input type="text" class="form-control" name="cell_phone" placeholder="12345678" value="{{ old('cell_phonr') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="activity">Actividad</label>
                        <input type="text" class="form-control" name="activity" placeholder="Electricista" value="{{ old('activity') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="business_address">Direccion Comercial</label>
                        <input type="text" class="form-control" name="business_address" placeholder="Corrientes 1100" value="{{ old('business_address') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="home_address">Direccion Personal</label>
                        <input type="text" class="form-control" name="home_address" placeholder="Corrientes 1100" value="{{ old('home_address') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="maximum_credit">Monto Maximo de Credito</label>
                        <input type="number" class="form-control" name="maximum_credit" placeholder="12345678" value="{{ old('maximum_credit') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" name="dni" placeholder="12345678" value="{{ old('dni') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </div>
@endsection