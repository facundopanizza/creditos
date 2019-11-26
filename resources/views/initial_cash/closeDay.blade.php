@extends('layouts.app')
@section('title', 'Cerrar Caja')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Monto</th>
        <th scope="col">Tipo</th>
        <th scope="col">Vendedor</th>
        <th scope="col">Cliente</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td class="text-success">+{{ $initialCash->entry_money }}</td>
        <td>Caja Inicial</td>
        <td></td>
        <td></td>
    </tr>
    @foreach($cashAllocations as $cashAllocation)
    <tr>
        <td>{{ $cashAllocation->money }}</td>
        <td>Plata Asignada a Vendedores</td>
        <td>{{ $cashAllocation->seller->first_name . ' ' . $cashAllocation->seller->last_name }}</td>
        <td></td>
    </tr>
    @endforeach
    @foreach($credits as $credit)
    <tr>
        <td class="text-danger">-{{ $credit->money }}</td>
        <td>Credito</td>
        <td>{{ $credit->seller->first_name . ' ' . $credit->seller->last_name }}</td>
        <td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
    </tr>
    @endforeach
    @foreach($payments as $payment)
    <tr>
        <td class="text-success">+{{ $payment->payment_amount }}</td>
        <td>Pago de Cuota</td>
        <td>{{ $payment->share->credit->seller->first_name . ' ' . $payment->share->credit->seller->last_name }}</td>
        <td>{{ $payment->share->credit->client->first_name . ' ' . $payment->share->credit->client->last_name }}</td>
    </tr>
    @endforeach
    @foreach($expenses as $expense)
    <tr>
        <td class="text-danger">-{{ $expense->money }}</td>
        <td>Gastos</td>
        <td>{{ $expense->seller->first_name . ' ' . $expense->seller->last_name }}</td>
        <td></td>
    </tr>
    @endforeach
    @foreach($cashEntries as $cashEntry)
    <tr>
        <td class='text-success'>+{{ $cashEntry->money }}</td>
        <td>Plata Devuelta por Vendedor</td>
        <td>{{ $cashEntry->seller->first_name . ' ' . $cashEntry->seller->last_name }}</td>
        <td></td>
    </tr>
    @endforeach
    <tr>
        <td>Plata Inicial: {{ $initialCash->entry_money }}</td>
        <td>Plata Final: {{ $total }}</td>
        <td class="@if($initialCash->entry_money > $total) text-danger @endif">Diferencia: {{ $total - $initialCash->entry_money }}</td>
    </tr>
</tbody>
</table>
@endsection