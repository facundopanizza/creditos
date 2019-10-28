@extends('layouts.app')

@section('title', 'Credito')

@section('main')
    <div class="card">
        <div class="card-header">
            Credito Numero {{ $credit->id }}
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><span class="text-secondary">Nombre Cliente: </span>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</div>
            <div class="col-md-3"><span class="text-secondary">Nombre Vendedor: </span>{{ $credit->seller->first_name . ' ' . $credit->seller->last_name }}</div>
            <div class="col-md-3"><span class="text-secondary">Dinero Prestado: </span>{{ $credit->money }}</div>
            <div class="col-md-3"><span class="text-secondary">Interes: </span>{{ $credit->interest_rate }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><span class="text-secondary">Ganancia: </span>{{ $credit->profit }}</div>
            <div class="col-md-3"><span class="text-secondary">Período: </span>{{ $credit->period }}</div>
            <div class="col-md-3"><span class="text-secondary">Fecha de Creacion: </span>{{ $credit->created_at }}</div>
            <div class="col-md-3"><span class="text-secondary">Fecha de Vencimiento: </span>{{ $credit->expiration_date }}</div>
        </div>
        <h3>Cuotas</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Precio</th>
                    <th scope="col">Vencimiento</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Firma</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credit->shares as $share)
                <tr>
                    <td>{{ $share->money }}</td>
                    <td></td>
                    <td></td>
                    <td>
                    @if(!empty($share->payment))
                        @if($share->payment->fee_cancelled)
                            {{ 'Pagado' }}
                        @else
                            <span class="text-danger">{{ 'Debe - ' . floatval($share->money - $share->payment->payment_amount) }}</span>
                        @endif
                    </td>
                    @else
                        <span class="text-danger">{{ 'Debe - ' . $share->money }}</span>
                    @endif
                    <td><a class="btn btn-primary" href="/shares/{{ $share->id }}/share_payments">Informar Pago</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection