@extends('layouts.app')

@section('title', 'Resumen')

@section('main')
<div class="card">
    <div class="card-header">
        {{ $user->first_name . ' ' . $user->last_name}}
    </div>
    <div class="card-body">
        <div class="row card-text pl-3 mb-3">
            <strong>Saldo: {{ $user->wallet }}</strong>
        </div>

        <h3>Cuotas del día</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a class="btn-sm btn-primary" href="">Ver Cuotas</a></th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cobradas</td>
                    <td>{{ $shares->paymentsCount }}</td>
                    <td>{{ $shares->paymentsAmount }}</td>
                </tr>
                <tr>
                    <td>En Mora</td>
                    <td>{{ $shares->expiredCount }}</td>
                    <td>{{ $shares->expiredAmount }}</td>
                </tr>
            </tbody>
        </table>
        <a href=""><h3>Creditos del día</h3></a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Cantidad</th>
                    <th>Monto Prestado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="col">Otorgados</td>
                    <td>{{ $credits->todayCount }}</td>
                    <td>{{ $credits->todayMoney }}</td>
                </tr>
                <tr>
                    <td scope="col">Cancelados</td>
                    <td>{{ $credits->cancelledCount }}</td>
                    <td>{{ $credits->cancelledMoney }}</td>
                </tr>
                <tr>
                    <td scope="col">En Mora</td>
                    <td>{{ $credits->expiredCount }}</td>
                    <td>{{ $credits->expiredMoney }}</td>
                </tr>
            </tbody>
        </table>
        <a href=""><h3>Gastos del día</h3></a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gastos</td>
                    <td>{{ $expenses->expensesCount }}</td>
                    <td>{{ $expenses->expensesMoney }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection