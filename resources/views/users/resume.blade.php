@extends('layouts.app')

@section('title', 'Resumen')

@section('main')
<div class="card">
    <div class="card-header d-flex justify-content-between">
		{{ $user->first_name . ' ' . $user->last_name}} 

		<a class="btn btn-primary btn-sm" href="/cash_entries">Atras</a>
    </div>
    <div class="card-body">
        <div class="row card-text pl-3 mb-3">
            <strong>Dinero en Mano: {{ $user->wallet }}</strong>
        </div>

        <h3>Cuotas del día</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a class="btn-sm btn-primary" href="/users/{{ $user->id  }}/resume/shares">Ver Cuotas</a></th>
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

        <h3>Creditos del día</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a class="btn-sm btn-primary" href="/users/{{ $user->id  }}/resume/credits">Ver Creditos</a></th>
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
        <h3>Gastos del día</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a class="btn-sm btn-primary" href="/users/{{ $user->id  }}/resume/expenses">Ver Gastos</a></th>
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

	@if($user->wallet != 0)
		<a class="btn btn-primary btn-sm" href="/users/{{ $user->id }}/resume/cash_entry">Cerrar Vendedor y Recibir Plata</a>
	@endif
</div>
@endsection
