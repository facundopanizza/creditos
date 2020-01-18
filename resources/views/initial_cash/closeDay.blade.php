@extends('layouts.app')
@section('title', 'Cerrar Caja')

@section('main')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Ingreso</th>
                <th scope="col">Egreso</th>
                <th scope="col">Gastos</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Caja Inicial</td>
                <td>{{ $initialCash->entry_money }}</td>
                <td></td>
                <td></td>
                <td>{{ $initialCash->entry_money }}</td>
            </tr>
            <tr>
                <td>Cobradores</td>
                <td class="text-success">+{{ $moneyFromPayments }}</td>
                <td class="text-danger">-{{ $moneyFromCredits }}</td>
                <td class="text-danger">-{{ $expenses }}</td>
                @if(($moneyFromCredits + $expenses) > $moneyFromPayments)
                    <td class="text-danger">-{{ $moneyFromCredits + $expenses - $moneyFromPayments }}</td>
                @else
                    <td class="text-success">+{{ $moneyFromPayments - $moneyFromCredits + $expenses }}</td>
                @endif
            </tr>
            <tr>
                <td></td>
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
</div>
<form action="/close_day" method="POST">
    @csrf
    <button class="btn btn-primary">Cerrar Caja</button>
</form>
@endsection
