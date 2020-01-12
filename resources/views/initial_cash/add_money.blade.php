@extends('layouts.app')

@section('title', 'Agregar Plata a la Caja')

@section('main')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>Agregar Plata a la Caja</p>
            <a class="btn btn-primary" href="/initial_cash">Atras</a>
        </div>
        <div class="card-body">
            <form method="POST" action="/add_money">
                @csrf

                <div class="form-group col-md-6">
                    <label for="money">Monto</label>
                    <input type="string" class="form-control" name="money"  value="{{ old('money') }}" required>
                    <button class="btn btn-primary mt-3">Agregar Plata</button>
                </div>
            </form>
        </div>
    </div>
@endsection