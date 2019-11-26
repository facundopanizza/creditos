@extends('layouts.app')

@section('title', 'Cierre de Caja')

@section('main')
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Monto</th>
                <th scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-success">+{{ $initial_cash->entry_money }}</td>
                <td>Caja Incial</td>
            </tr>
            <tr>
                <td class="text-success">+{{ $payed }}</td>
                <td>Cobrado</td>
            </tr>
            <tr>
                <td class="text-danger">-{{ $borrowed }}</td>
                <td>Prestado</td>
            </tr>
            <tr>
                <td class="text-center" colspan="3">
                    Monto Final: {{ $initial_cash->entry_money + $payed - $borrowed }}
                </td>
            </tr>
        </tbody>
    </table
@endsection