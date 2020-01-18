@extends('layouts.app')

@section('title', 'Cuotas')

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

        <h3>Cuotas Cobradas</h3>
		<div class="table-responsive-md">
			<table class="table table-hover">

				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Monto</th>
						<th scope="col">Numero de Cuota</th>
						<th scope="col">Cliente</th>
						<th scope="col">Fecha</th>
					</tr>
				</thead>

				<tbody>
				<?php
					$count = 0;
				?>
				@foreach($shares->allPayed->sortByDesc('created_at') as $share)
					<?php
						$count += 1;
					?>
					<tr>
						<td>{{ $count }}</td>
						<td>{{ $share->payment_amount }}</td>
						<td>{{ $share->share->share_number }}</td>
						<td>{{ $share->share->credit->client->first_name . ' ' . $share->share->credit->client->last_name }}</td>
						<td>{{ $share->created_at }}</td>
					</tr>
				@endforeach
					<tr>
						<td>Total: {{ $shares->paymentsAmount }}</td>
					</tr>
				</tbody>
			</table>
		</div>

        <h3>Cuotas Vencidas</h3>
		<div class="table-responsive-md">
			<table class="table table-hover">

				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Monto</th>
						<th scope="col">Numero de Cuota</th>
						<th scope="col">Cliente</th>
						<th scope="col">Fecha</th>
					</tr>
				</thead>

				<tbody>
				<?php
					$count = 0;
				?>
				@foreach($shares->allExpired->sortByDesc('created_at') as $share)
					<?php
						$count += 1;
					?>
					<tr>
						<td>{{ $count }}</td>
						<td>{{ $share->money }}</td>
						<td>{{ $share->share_number }}</td>
						<td>{{ $share->credit->client->first_name . ' ' . $share->credit->client->last_name }}</td>
						<td>{{ $share->created_at }}</td>
					</tr>
				@endforeach
					<tr>
						<td>Total: {{ $shares->expiredAmount }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
