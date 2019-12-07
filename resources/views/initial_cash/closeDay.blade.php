@extends('layouts.app')
@section('title', 'Cerrar Caja')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col"></th>
        <th scope="col">Ingreso</th>
        <th scope="col">Egreso</th>
        <th scope="col">Total</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Caja Inicial</td>
        <td>{{ $initialCash->entry_money }}</td>
        <td></td>
        <td>{{ $initialCash->entry_money }}</td>
    </tr>
    <tr>
        <td>Cobradores</td>
        <td class="text-success">+{{ $moneyFromPayments }}</td>
        <td class="text-danger">-{{ $moneyFromCredits }}</td>
        @if($moneyFromCredits > $moneyFromPayments)
            <td class="text-danger">-{{ $moneyFromCredits - $moneyFromPayments }}</td>
        @else
            <td class="text-success">+{{ $moneyFromPayments - $moneyFromCredits }}</td>
        @endif
    </tr>
    <tr>
        <td>Gastos</td>
        <td></td>
        <td class="text-danger">-{{ $expenses }}</td>
        <td class="text-danger">-{{ $expenses }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        @if($initialCash->money > $initialCash->entry_money)
            <td class="text-success">Total: {{ $initialCash->money }}</td>
        @else
            <td class="text-danger">Total: {{ $initialCash->money }}</td>
        @endif
    </tr>
</tbody>
</table>
<form action="/close_day" method="POST">
    @csrf
    <button class="btn btn-primary">Cerrar Caja</button>
</form>
@endsection