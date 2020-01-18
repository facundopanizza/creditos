@extends('layouts.app')

@section('title', 'Clientes')

@section('main')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero de Cliente</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">DNI</th>
                <th scope="col">Deuda Total del Cliente</th>
                @if(Auth::user()->role == 'admin')
                    <th scope="col">Vendedor</th>
                @endif
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->first_name }}</td>
                <td>{{ $client->last_name }}</td>
                <td>{{ $client->dni }}</td>
                <td>{{ $client->debt }}</td>
                @if(Auth::user()->role == 'admin')
                    <td>{{ $client->seller->first_name . ' ' . $client->seller->last_name }}</td>
                @endif
                <td><a href="/clients/{{ $client->id }}" class="btn btn-primary">Ver Cliente</a></td>
                <td><a href="/clients/{{ $client->id }}/credits/create" class="btn btn-primary">Nuevo Credito</a></td>
                <td><a href="/clients/{{ $client->id }}/edit" class="btn btn-primary">Editar</a></td>
                {{-- <td>
                    <form action="/clients/{{ $client->id }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </form>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
