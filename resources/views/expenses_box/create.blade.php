@extends('layouts.app')
@section('title', 'Nuevo Gasto')

@section('main')
<div class="card">
    <div class="card-header">
        Nuevo Gasto de Caja
    </div>
    <div class="card-body">
        <form method="POST" action="/expenses_box" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" required>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="money">Monto</label>
                <input type="number" name="money" class="form-control @error('money') is-invalid @enderror" value="{{ old('money') }}" required>
                @error('money')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Nuevo Gasto de Caja</button>
        </form>
    </div>
</div>
@endsection