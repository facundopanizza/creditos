@extends('layouts.app')

@section('title', 'Imprimir Comprobante')

@section('main')
    @foreach($share->payments as $payment)
    <div class="card">
        <div class="card-header">Comprobante de Pago</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">Cliente: {{ $share->credit->client->first_name }} {{ $share->credit->client->last_name }}</div>
                <div class="col-md-3">Numero de Credito: {{ $share->credit->id }}</div>
                <div class="col-md-3">Numero de Cuota: {{ $share->share_number }}</div>
                <div class="col-md-3">Numero de Pago: {{ $payment->id }}</div>
            </div>
            <div class="row mt-5">
                <div class="col-md-3">Cantidad Pagada: {{ $payment->payment_amount }}</div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-md-12">Firma:</div>
            </div>

            @if($share->payments->count() > 1)
                <a class="btn btn-primary" href="/shares/{{ $share->id }}/payment/{{ $payment->id }}">Imprimir</a>
            @endif
        </div>
    </div>
    @endforeach
@endsection