@extends('layouts.app')

@section('title', 'Inicio de Caja')

@section('main')
    <div class="card">
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
    </div>
@endsection