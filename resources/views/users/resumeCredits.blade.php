@extends('layouts.app')

@section('title', 'Creditos')

@section('main')
	
<div class="card">

    <div class="card-header d-flex justify-content-between">
		{{ $user->first_name . ' ' . $user->last_name}} 

		<a class="btn btn-primary btn-sm" href="/users/{{ $user->id }}/resume">Atras</a>
    </div>

    <div class="card-body">
        <div class="row card-text pl-3 mb-3">
            <strong>Dinero en Mano: {{ $user->wallet }}</strong>
        </div>

        <h3>Creditos Otorgados</h3>
		<div class="table-responsive">
			<table class="table table-hover">

				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Monto</th>
						<th scope="col">Ganancia</th>
						<th scope="col">Cantidad de Cuotas</th>
						<th scope="col">Cliente</th>
						<th scope="col">Fecha</th>
						<th scope="col"></th>
					</tr>
				</thead>

				<tbody>
				<?php
					$count = 0;
				?>
				@foreach($credits->allNormal->sortByDesc('created_at') as $credit)
					<?php
						$count += 1;
					?>
					<tr>
						<td>{{ $count }}</td>
						<td>{{ $credit->money }}</td>
						<td>{{ $credit->profit }}</td>
						<td>{{ $credit->shares_numbers }}</td>
						<td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
						<td>{{ $credit->created_at }}</td>
						<td><a class="btn btn-primary btn-sm" href="/credits/{{ $credit->id }}">Ver Credito</a></td>
					</tr>
				@endforeach
					<tr>
						<td>Total: {{ $credits->todayMoney }}</td>
					</tr>
				</tbody>
			</table>
		</div>

        <h3>Creditos Cancelados</h3>
		<div class="table-responsive">
			<table class="table table-hover">

				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Monto</th>
						<th scope="col">Ganancia</th>
						<th scope="col">Cantidad de Cuotas</th>
						<th scope="col">Cliente</th>
						<th scope="col">Fecha</th>
						<th scope="col"></th>
					</tr>
				</thead>

				<tbody>
				<?php
					$count = 0;
				?>
				@foreach($credits->allCancelled->sortByDesc('created_at') as $credit)
					<?php
						$count += 1;
					?>
					<tr>
						<td>{{ $count }}</td>
						<td>{{ $credit->money }}</td>
						<td>{{ $credit->profit }}</td>
						<td>{{ $credit->shares_numbers }}</td>
						<td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
						<td>{{ $credit->created_at }}</td>
						<td><a class="btn btn-primary btn-sm" href="/credits/{{ $credit->id }}">Ver Credito</a></td>
					</tr>
				@endforeach
					<tr>
						<td>Total: {{ $credits->cancelledMoney }}</td>
					</tr>
				</tbody>
			</table>
		</div>

        <h3>Creditos en Mora</h3>
		<div class="table-responsive">
			<table class="table table-hover">

				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Monto</th>
						<th scope="col">Ganancia</th>
						<th scope="col">Cantidad de Cuotas</th>
						<th scope="col">Cliente</th>
						<th scope="col">Fecha</th>
						<th scope="col"></th>
					</tr>
				</thead>

				<tbody>
				<?php
					$count = 0;
				?>
				@foreach($credits->allExpired->sortByDesc('created_at') as $credit)
					<?php
						$count += 1;
					?>
					<tr>
						<td>{{ $count }}</td>
						<td>{{ $credit->money }}</td>
						<td>{{ $credit->profit }}</td>
						<td>{{ $credit->shares_numbers }}</td>
						<td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
						<td>{{ $credit->created_at }}</td>
						<td><a class="btn btn-primary btn-sm" href="/credits/{{ $credit->id }}">Ver Credito</a></td>
					</tr>
				@endforeach
					<tr>
						<td>Total: {{ $credits->expiredMoney }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
