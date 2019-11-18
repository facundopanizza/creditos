@extends('layouts.app')

@section('title', 'Inicio de Caja')

@section('main')
    <div class="card">
        <div class="card-header">
            Dar Plata
        </div>
        <div class="card-body">
            <form method="POST" action="/users/{{ $user->id }}/cash_allocation">
                @csrf

                <div class="form-group">
                    <label for="entry_money">Plata</label>
                    <input type="number" class="form-control @error('money') is-invalid @enderror" name="money" value="{{ old('money') }}" required>
                    @error('money')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Dar Plata</button>
            </form>
        </div>
    </div>
@endsection