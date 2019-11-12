@extends('layouts.app')

@if(Auth::user()->role === 'seller')
    @section('title', 'Resumen de Hoy')
@endif

@section('title', 'Estadísticas')
@section('main')
    <h3 class="mt-2">Cuotas Vencidas</h3>
    @foreach($expiredShares as $share)
    <div class="card-columns">
        <div class="card">
            <div class="card-header bg-danger"></div>
            <div class="card-body">
                <div class="text-center">
                    <p class="card-title"><span class="text-secondary">Cliente: </span>{{ $share->credit->client->first_name . ' ' . $share->credit->client->last_name }}</p>
                </div>
                <div class="row justify-content-around">
                    <div>
                            @if($share->payments->count() === 0)
                                <span class="text-secondary">Debe</span><p>${{ $share->money }}</p>
                            @else
                                <?php
                                    $payed = 0;

                                    foreach($share->payments as $payment) {
                                        $payed += $payment->payment_amount;
                                    }
                                ?>
                                <span class="text-secondary">Debe</span><p>${{ $share->money - $payed }}</p>
                            @endif
                    </div>
                    <div>
                        <span class="text-secondary">Vencimiento</span><p>{{ $share->expiration_date->isoFormat('DD/MM/YYYY') }}</p>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <a href="/credits/{{ $share->credit->id }}" class="btn btn-primary text-white">Ver Credito</a>
                    <a href="/shares/{{ $share->id }}/share_payments" class="btn btn-success text-white">Cobrar Cuota</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <hr>

    <h3 class="mt-2">Cuotas a Cobrar Hoy</h3>
    @foreach($todayShares as $share)
    @if($share->share_cancelled === 0)
        <div class="card-columns">
            <div class="card">
                <div class="card-header bg-primary"></div>
                <div class="card-body">
                    <div class="text-center">
                        <p class="card-title"><span class="text-secondary">Cliente: </span>{{ $share->credit->client->first_name . ' ' . $share->credit->client->last_name }}</p>
                    </div>
                    <div class="row justify-content-around">
                        <div>
                            @if($share->payments->count() === 0)
                                <span class="text-secondary">Debe</span><p>${{ $share->money }}</p>
                            @else
                                <?php
                                    $payed = 0;

                                    foreach($share->payments as $payment) {
                                        $payed += $payment->payment_amount;
                                    }
                                ?>
                                <span class="text-secondary">Debe</span><p>${{ $share->money - $payed }}</p>
                            @endif
                        </div>
                        <div>
                            <span class="text-secondary">Vencimiento</span><p>{{ $share->expiration_date->isoFormat('DD/MM/YYYY') }}</p>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <a href="/credits/{{ $share->credit->id }}" class="btn btn-primary text-white">Ver Credito</a>
                        <a href="/shares/{{ $share->id }}/share_payments" class="btn btn-success text-white">Cobrar Cuota</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endforeach
    <hr>
@endsection