@extends('layouts.app')

@section('title', 'Gastos')

@section('main')
<div class="card">

    <div class="card-header d-flex justify-content-between">
		{{ $user->first_name . ' ' . $user->last_name }} 

		<a class="btn btn-primary btn-sm" href="/users/{{ $user->id  }}/resume">Atras</a>
    </div>

    <div class="card-body">
        <div class="row card-text pl-3 mb-3">
            <strong>Dinero en Mano: {{ $user->wallet  }}</strong>
        </div>

        <h3>Gastos</h3>
        <table class="table table-hover">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Fecha</th>
					<th></th>
                </tr>
            </thead>

            <tbody>
			<?php
				$count = 0;
			?>
			@foreach($expenses->allExpenses as $expense)
			<?php
				$count += 1;
			?>
				<tr>
					<td>{{ $count  }}</td>
					<td>{{ $expense->money  }}</td>
					<td>{{ $expense->description }}</td>
					<td>{{ $expense->created_at  }}</td>
					<td><a class="btn btn-primary btn-sm" href="/expenses/{{ $expense->id }}">Ver Gasto</a></td>
				</tr>
			@endforeach
				<tr>
					<td>Total: {{ $expenses->expensesMoney  }}</td>
				</tr>
            </tbody>
		</table>
@endsection
