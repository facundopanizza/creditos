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
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Juan" value="{{ old('first_name') }}" required>
                        @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Perez" value="{{ old('last_name') }}" required>
                        @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="phone">Numbero de Telefono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="12345678" value="{{ old('phone') }}" required>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cell_phone">Numero de Celular</label>
                        <input type="text" class="form-control @error('cell_phone') is-invalid @enderror" name="cell_phone" placeholder="12345678" value="{{ old('cell_phone') }}" required>
                        @error('cell_phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="activity">Actividad</label>
                        <input type="text" class="form-control @error('activity') is-invalid @enderror" name="activity" placeholder="Electricista" value="{{ old('activity') }}" required>
                        @error('activity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="business_address">Direccion Comercial</label>
                        <input type="text" class="form-control @error('business_address') is-invalid @enderror" name="business_address" placeholder="Corrientes 1100" value="{{ old('business_address') }}" required>
                        @error('business_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="home_address">Direccion Personal</label>
                        <input type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" placeholder="Corrientes 1100" value="{{ old('home_address') }}" required>
                        @error('home_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="maximum_credit">Monto Maximo de Credito</label>
                        <input type="number" class="form-control @error('maximum_credit') is-invalid @enderror" name="maximum_credit" placeholder="12345678" value="{{ old('maximum_credit') }}" required>
                        @error('maximum_credit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" name="dni" placeholder="12345678" value="{{ old('dni') }}" required>
                        @error('dni')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </div>
@endsection