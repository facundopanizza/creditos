@extends('layouts.app')
@section('title', 'Gasto')

@section('main')
<div class="card">
    <div class="card-header">
        Gasto Numero: {{ $expensesBox->id }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="mr-3">
                <div class="text-secondary">Descripción:</div>
                <div class="ml-1">{{ $expensesBox->description }}</div>
            </div>

            <div>
                <div class="text-secondary">Gastado Por:</div>
                <div class="ml-1"><a href="/users/{{ $expensesBox->seller->id }}/resume">{{ $expensesBox->seller->first_name }} {{ $expensesBox->seller->last_name }}</a></div>
            </div>
        </div>
    </div>
</div>
@endsection