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

                <div class="form-group">
                    <label for="first_name">Nombre</label>
                    <input type="text" class="form-control" name="first_name" placeholder="Juan" value="{{ $client->first_name }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Perez" value="{{ $client->last_name }}" required>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="number" class="form-control" name="dni" placeholder="12345678" value="{{ $client->dni }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
        </div>
    </div>
@endsection