@extends('layouts.app')

@section('title', 'Lista de Creditos')

@section('main')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero de Credito</th>
                <th scope="col">Nombre Vendedor</th>
                <th scope="col">Nombre Cliente</th>
                <th scope="col">Dinero Prestado</th>
                <th scope="col">Interes</th>
                <th scope="col">Ganacia</th>
                <th scope="col">Ganacia del Vendedor</th>
                <th scope="col">Período</th>
                <th scope="col">Fecha Creacion</th>
                <th scope="col">Fecha Vencimiento</th>
                <th scope="col">Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(Auth::user()->role === 'admin')
                @foreach($credits->sortByDesc('created_at') as $credit)
                <tr>
                    <td>{{ $credit->id }}</td>
                    <td>{{ $credit->seller->first_name . ' ' . $credit->seller->last_name }}</td>
                    <td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
                    <td>{{ $credit->money }}</td>
                    <td>{{ $credit->interest_rate }}</td>
                    <td>{{ $credit->profit }}</td>
                    <td>{{ $credit->seller_profit }}</td>
                    <td>{{ $credit->period }}</td>
                    <td>{{ $credit->created_at }}</td>
                    <td>{{ $credit->expiration_date }}</td>
                    <td>
                        @if($credit->credit_cancelled === 1)
                            <span class="text-success">Abonado</span>
                        @else
                            <span class="text-danger">Pendiente</span>
                        @endif
                    </td>
                    <td><a class="btn btn-primary" href="/credits/{{ $credit->id }}">Ver Credito</a></td>
                </tr>
                @endforeach
            @elseif(Auth::user()->role === 'seller')
                @foreach(Auth::user()->credits->sortByDesc('created_at') as $credit)
                <tr>
                    <td>{{ $credit->id }}</td>
                    <td>{{ $credit->seller->first_name . ' ' . $credit->seller->last_name }}</td>
                    <td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
                    <td>{{ $credit->money }}</td>
                    <td>{{ $credit->interest_rate }}</td>
                    <td>{{ $credit->profit }}</td>
                    <td>{{ $credit->period }}</td>
                    <td>{{ $credit->created_at }}</td>
                    <td>{{ $credit->expiration_date }}</td>
                    <td>
                        @if($credit->credit_cancelled === 1)
                            <span class="text-success">Abonado</span>
                        @else
                            <span class="text-danger">Pendiente</span>
                        @endif
                    </td>
                    <td><a class="btn btn-primary" href="/credits/{{ $credit->id }}">Ver Credito</a></td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection