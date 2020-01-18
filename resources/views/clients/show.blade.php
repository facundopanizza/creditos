@extends('layouts.app')

@section('title', "Informe Cliente - {$client->first_name} {$client->last_name}")

@section('main')
    <div class="card">
        <div class="card-header row justify-content-between">
            <div>
                {{ $client->first_name . ' ' . $client->last_name}}
            </div>
            <a href="/clients/{{ $client->id }}/credits/create" class="btn btn-primary">Nuevo Credito</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <span class="text-secondary">Numero de Cliente:</span> {{ $client->id }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">DNI:</span> {{ $client->dni }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">Telefono:</span> {{ $client->phone }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">Celular:</span> {{ $client->cell_phone }}
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <span class="text-secondary">Actividad:</span> {{ $client->activity }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">Direccion Comercial:</span> {{ $client->business_address }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">Direccion Personal:</span> {{ $client->home_address }}
                </div>

                <div class="col-md-3">
                    <span class="text-secondary">Monto Maximo de Credito:</span> {{ $client->maximum_credit }}
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <span class="text-secondary">Deuda Total del Cliente:</span> {{ $client->debt }}
                </div>
            </div> 

            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Numero de Credito</th>
                            <th scope="col">Fecha de Creacion</th>
                            <th scope="col">Fecha de Vencimiento</th>
                            <th scope="col">Dinero Prestado</th>
                            <th scope="col">Interes</th>
                            <th scope="col">Cuotas</th>
                            <th scope="col">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->credits as $credit)
                        <tr>
                            <td>{{ $credit->id }}</td>
                            <td>{{ $credit->created_at }}</td>
                            <td>{{ $credit->expiration_date }}</td>
                            <td>{{ $credit->money }}</td>
                            <td>{{ $credit->interest_rate }}%</td>
                            <td>{{ $credit->shares->count() }}</td>
                            <td>
                                @if($credit->credit_cancelled === 1)
                                    <span class="text-success">Abonado</span>
                                @else
                                    <span class="text-danger">Pendiente</span>
                                @endif
                            </td>
                            <td><a href="/credits/{{ $credit->id }}" class="btn btn-primary">Ver Credito</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection