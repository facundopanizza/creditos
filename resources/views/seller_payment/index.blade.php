@extends('layouts.app')

@section('title', 'Pagar a Vendedor')

@section('main')
    <div class="card">
        <div class="card-header">
            Pagar a Vendedores
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Vendedor</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td><a href="/users/{{ $payment->seller->id }}/resume">{{ $payment->seller->first_name }} {{ $payment->seller->last_name }}</a></td>
                            <td>{{ $payment->money }}</td>
                            <td>{{ $payment->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection