@extends('layouts.app')

@section('title', 'Pagar a Vendedor')

@section('main')
    <div class="card">
        <div class="card-header">
            Pagar a Vendedores
        </div>
        <div class="card-body">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Vendedor</th>
                    <th scope="col">Monto</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $seller)
                @if(!empty($seller->payment))
                <tr>
                    <td><a href="/users/{{ $seller->id }}/resume">{{ $seller->first_name }} {{ $seller->last_name }}</a></td>
                    <td>{{ $seller->payment }}</td>
                    <td><a class="btn btn-primary" href="/users/{{ $seller->id }}/payments/create">Pagar</a></td>
                </tr>
                @endif
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection