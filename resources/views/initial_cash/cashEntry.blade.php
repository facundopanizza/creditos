@extends('layouts.app')
@section('title', 'Recibir Plata')

@section('main')
<div class="card">
    <div class="card-header">Recibir Plata</div>
    <div class="card-body">
        <form method="POST" action="cash_entries">
            @csrf
            @error('cerrar')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror

            @foreach($sellers as $seller)
            <div class="form-group">
                <input type="checkbox" name="sellers[]" value="{{ $seller->id }}">
                <label for="sellers">{{ $seller->first_name . ' ' . $seller->last_name}} - Entrega {{ $seller->wallet }}</label>
            </div>
            @endforeach

            <input type="submit" value="Recibir Plata">
        </form>
    </div>
</div>
@endsection