@extends('layouts.app')

@section('title', 'Vendedores')

@section('main')
<div class="table-responsive-md">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero de Vendedor</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">DNI</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
            <tr>
                <td>{{ $seller->id }}</td>
                <td>{{ $seller->first_name }}</td>
                <td>{{ $seller->last_name }}</td>
                <td>{{ $seller->dni }}</td>
                <td><a href="/users/{{ $seller->id }}/cash_allocation" class="btn btn-primary">Dar Plata</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection