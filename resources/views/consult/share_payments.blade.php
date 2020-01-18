@extends('layouts.app')

@section('title', 'Resultados')

@section('main')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero de Cuota</th>
                <th scope="col">Nombre Vendedor</th>
                <th scope="col">Nombre Cliente</th>
                <th scope="col">Dinero Pagado</th>
                <th scope="col">Valor de Cuota</th>
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Fecha Vencimiento</th>
                <th scope="col">Estado de la Cuota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results->sortByDesc('created_at') as $sharePayment)
            <tr>
                <td>{{ $sharePayment->share->share_number }}</td>
                <td>{{ $sharePayment->share->credit->seller->first_name . ' ' . $sharePayment->share->credit->seller->last_name }}</td>
                <td>{{ $sharePayment->share->credit->client->first_name . ' ' . $sharePayment->share->credit->client->last_name }}</td>
                <td>{{ $sharePayment->payment_amount }}</td>
                <td>{{ $sharePayment->share->money }}</td>
                <td>{{ $sharePayment->created_at }}</td>
                <td>{{ $sharePayment->share->expiration_date }}</td>
                <td>
                    @if($sharePayment->share->share_cancelled === 1)
                        <span class="text-success">Abonado</span>
                    @else
                        <span class="text-danger">Pendiente</span>
                    @endif
                </td>
                <td><a class="btn btn-primary" href="/credits/{{ $sharePayment->share->credit->id }}">Ver Credito</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
<div class="table-responsive">
@endsection