@extends('layouts.app')

@section('title', 'Usuarios')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Numero de Usuario</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">DNI</th>
        <th scope="col">Rol</th>
        <th scope="col">Email</th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->first_name }}</td>
        <td>{{ $user->last_name }}</td>
        <td>{{ $user->dni }}</td>
        <td>{{ $user->role }}</td>
        <td>{{ $user->email }}</td>
        <td><a href="/users/{{ $user->id }}/edit" class="btn btn-primary">Editar</a></td>
        <td><a href="/users/{{ $user->id }}/resume" class="btn btn-primary">Resumen</a></td>
        <td><a href="/users/{{ $user->id }}/cash_allocation" class="btn btn-primary">Dar Plata</a></td>
        <td>
            <form action="/users/{{ $user->id }}" method="POST">
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