@extends('layouts.app')

@section('title', 'Clientes')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Numero de Cliente</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">DNI</th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
    @foreach($clients as $client)
    <tr>
        <td>{{ $client->id }}</td>
        <td>{{ $client->first_name }}</td>
        <td>{{ $client->last_name }}</td>
        <td>{{ $client->dni }}</td>
        <td><a href="/clients/{{ $client->id }}/edit" class="btn btn-primary">Editar</a></td>
        <td>
            <form action="/clients/{{ $client->id }}" method="POST">
                @csrf
                @method('DELETE')

                <input type="submit" class="btn btn-danger" value="Eliminar">
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@endsection