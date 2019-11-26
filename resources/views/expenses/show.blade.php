@extends('layouts.app')
@section('title', 'Gasto')

@section('main')
<div class="card">
    <div class="card-header">
        Gasto Numero: {{ $expense->id }}
    </div>
    <div class="card-body">
        <div class="text-secondary">Descripción:</div>
        <div class="ml-1">{{ $expense->description }}</div>
        @if($expense->picture !== null)
            <img class="img-fluid" src="{{ asset($expense->picture) }}">
        @endif
    </div>
</div>
@endsection