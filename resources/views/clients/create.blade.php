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

                <div class="form-group">
                    <label for="first_name">Nombre</label>
                    <input type="text" class="form-control" name="first_name" placeholder="Juan" value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Perez" value="{{ old('last_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="number" class="form-control" name="dni" placeholder="12345678" value="{{ old('dni') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </div>
@endsection