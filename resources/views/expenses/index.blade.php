@extends('layouts.app')

@section('title', 'Gastos del Día')

@section('main')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Monto</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha <a class="btn btn-success" href="/expenses/create">Nuevo Gasto</a></th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                @if($expense->credit_id !== null)
                    <td class="text-danger">-{{ $expense->money }}</td>
                    <td><a href="/credits/{{ $expense->credit_id }}">Creacion de Credito</a></td>
                    <td>{{ $expense->created_at }}</td>
                @elseif($expense->sharePayment_id !== null)
                    <td class="text-success">+{{ $expense->money }}</td>
                    <td><a href="/credits/{{ $expense->payment->share->credit->id }}">Cobro de Cuota numero {{ $expense->payment->share->share_number }} del credito {{ $expense->payment->share->credit->id }}</a></td>
                    <td>{{ $expense->created_at }}</td>
                @elseif($expense->cashAllocation_id !== null)
                    <td class="text-success">+{{ $expense->money }}</td>
                    <td><a href="/credits/{{ $expense->credit_id }}">Asignacion de Plata</a></td>
                    <td>{{ $expense->created_at }}</td>
                @elseif($expense->description !== null)
                    <td class="text-danger">-{{ $expense->money }}</td>
                    <td><a href="/expenses/{{ $expense->id }}">{{ $expense->description }}</a></td>
                    <td>{{ $expense->created_at }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection