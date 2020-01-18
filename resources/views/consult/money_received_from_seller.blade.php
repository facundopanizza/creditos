@extends('layouts.app')

@section('title', 'Resultados')

@section('main')
<div class="table-responsive-md">
    <table class="table table-hover"> <thead>
        <tr>
            <th scope="col">Nombre Vendedor</th>
            <th scope="col">Monto Recibido</th>
            <th scope="col">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results->sortByDesc('created_at') as $payment)
        <tr>
            <td>{{ $payment->seller->first_name . ' ' . $payment->seller->last_name }}</td>
            <td>{{ $payment->money }}</td>
            <td>{{ $payment->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>
@endsection