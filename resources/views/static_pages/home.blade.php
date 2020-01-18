@extends('layouts.app')

@section('title', 'Resumen de Hoy')

@section('title', 'Estadísticas')
@section('main')
    <h3 class="mt-2">Cuotas Vencidas</h3>
    <div class="table-responsive-md">
        <table class="table table-hover">
            <thead>
                <tr class="bg-danger text-white">
                    <th scope="col">Numero de Cuota</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Deuda</th>
                    <th scope="col">Fecha de Vencimiento</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($expiredShares as $share)
                <?php
                    $payed = 0;
                    foreach($share->payments as $payment) {
                        $payed += $payment->payment_amount;
                    }
                    $debt = $share->money - $payed;
                ?>
                <tr>
                    <td>{{ $share->share_number }}</td>
                    <td>{{ $share->credit->client->first_name . ' ' . $share->credit->client->last_name }}</td>
                    <td>{{ $debt }}</td>
                    <td>{{ $share->expiration_date->isoFormat('DD/MM/YYYY') }}</td>
                    <td><a class="btn btn-success" href="/shares/{{ $share->id }}/share_payments">Cobrar Cuota</a></td>
                    <td><a class="btn btn-primary" href="/credits/{{ $share->credit->id }}">Ver Credito</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <hr>

    <h3 class="mt-2">Cuotas a Cobrar Hoy</h3>
    <div class="table-responsive-md">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Numero de Cuota</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Deuda</th>
                    <th scope="col">Fecha de Vencimiento</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($todayShares as $share)
            @if($share->share_cancelled === 0)
                <?php
                    $payed = 0;
                    foreach($share->payments as $payment) {
                        $payed += $payment->payment_amount;
                    }
                    $debt = $share->money - $payed;
                ?>
                <tr>
                    <td>{{ $share->share_number }}</td>
                    <td>{{ $share->credit->client->first_name . ' ' . $share->credit->client->last_name }}</td>
                    <td>{{ $debt }}</td>
                    <td>{{ $share->expiration_date->isoFormat('DD/MM/YYYY') }}</td>
                    <td><a class="btn btn-success" href="/shares/{{ $share->id }}/share_payments">Cobrar Cuota</a></td>
                    <td><a class="btn btn-primary" href="/credits/{{ $share->credit->id }}">Ver Credito</a></td>
                </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection