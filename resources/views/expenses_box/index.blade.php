@extends('layouts.app')

@section('title', 'Gastos del Día')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Monto</th>
        <th scope="col">Descripción</th>
        <th scope="col">Fecha <a class="btn btn-success" href="/expenses_box/create">Nuevo Gasto</a></th>
    </tr>
</thead>
<tbody>
    @foreach($expensesBox->sortByDesc('created_at') as $expense)
    <tr>
        @if($expense->cashEntries_id !== null)
            <td class="text-success">+{{ $expense->money }}</td>
            <td><a href="/users/{{$expense->seller->id}}/resume">Plata recibida del vendedor {{$expense->seller->first_name }} {{$expense->seller->last_name}}</a></td>
            <td>{{ $expense->created_at }}</td>
        @elseif($expense->cashAllocation_id !== null)
            <td class="text-danger">-{{ $expense->money }}</td>
            <td><a href="/users/{{$expense->seller->id}}/resume">Asignacion de Plata a {{$expense->seller->first_name }} {{$expense->seller->last_name}}</a></td>
            <td>{{ $expense->created_at }}</td>
        @elseif($expense->description !== null)
            <td class="text-danger">-{{ $expense->money }}</td>
            <td><a href="/expenses_box/{{ $expense->id }}">{{ $expense->description }}</a></td>
            <td>{{ $expense->created_at }}</td>
        @endif
    </tr>
    @endforeach
</tbody>
</table>
@endsection