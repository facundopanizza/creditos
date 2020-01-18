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
                <td>
                    <form action="/users/{{ $user->id }}/enable" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="submit" class="btn btn-primary" value="Habilitar Usuario">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection