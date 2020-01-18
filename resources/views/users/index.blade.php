@extends('layouts.app')

@section('title', 'Usuarios')

@section('main')
<div class="table-responsive-md">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero de Usuario</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">DNI</th>
                <th scope="col">Rol</th>
                <th scope="col">Email</th>
                <th scope="col">Comision</th>
                <th scope="col">Plata en Mano</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @if($user->role !== 'disabled')
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->dni }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->commission }}</td>
                <td>{{ $user->wallet }}</td>
                <td><a href="/users/{{ $user->id }}/edit" class="btn btn-primary">Editar</a></td>
                <td><a href="/users/{{ $user->id }}/resume" class="btn btn-primary">Resumen</a></td>
                <td><a href="/users/{{ $user->id }}/clients" class="btn btn-primary">Ver Clientes</a></td>
                <td>
                    <form action="/users/{{ $user->id }}/disable" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="submit" class="btn btn-danger" value="Deshabilitar Usuario">
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection
