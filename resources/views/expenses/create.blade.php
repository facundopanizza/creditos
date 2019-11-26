@extends('layouts.app')
@section('title', 'Nuevo Gasto')

@section('main')
<div class="card">
    <div class="card-header">
        Nuevo Gasto
    </div>
    <div class="card-body">
        <form method="POST" action="/expenses" enctype="multipart/form-data">
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
            <div class="form-group">
                <label for="picture">Factura</label>
                <input type="file" name="picture" class="form-control @error('picture') is-invalid @enderror" accept="image/*" required>
                @error('picture')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Nuevo Gasto</button>
        </form>
    </div>
</div>
@endsection