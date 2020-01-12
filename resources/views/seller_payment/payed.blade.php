@extends('layouts.app')

@section('title', 'Se pago con exito')

@section('main')
    <div class="card">
        <div class="card-header">
            Se pago con exito
        </div>

        <div class="card-body">
            Se pago {{ $seller->payment }} al vendedor {{ $seller->first_name }} {{ $seller->last_name }}
        </div>
    </div>
@endsection