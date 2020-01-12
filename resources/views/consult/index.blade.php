@extends('layouts.app')

@section('title', 'Consultar')

@section('main')
    <div class="card">
        <div class="card-header">
            Consultar
        </div>
        <div class="card-body">
            <form method="POST" action="/consult/seller">
                <h4>Por Vendedor</h4>
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="seller_id">Vendedor</label>
                        <select list="seller_id" class="form-control" name="seller_id" required>
						@foreach($sellers as $seller)
							<option value="{{ $seller->id }}">
								{{ $seller->first_name . ' ' . $seller->last_name }}
							</option>
						@endforeach
						</select>
                        @error('seller_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="search_type">Tipo de Busqueda</label>
                        <select list="search_type" class="form-control" name="search_type" required>
							<option value="credits">Creditos</option>
							<option value="share_payments">Cuotas Cobradas</option>
							<option value="payments_to_seller">Pagos de Sueldo</option>
							<option value="money_received_from_seller">Plata entregada por el vendedor</option>
                        </select>
                        @error('search_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="from">Desde</label>
                        <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}" required>
                        @error('from')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="to">Hasta</label>
                        <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}" required>
                        @error('to')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

				<button type="submit" class="btn btn-primary">Consultar</button>
            </form>

            <form class="mt-3" method="POST" action="/consult/client">
                <h4>Por Cliente</h4>
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="client_id">Cliente</label>
                        <select list="client_id" class="form-control" name="client_id" required>
						@foreach($clients as $client)
							<option value="{{ $client->id }}">
								{{ $client->first_name . ' ' . $client->last_name }}
							</option>
						@endforeach
						</select>
                        @error('client_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="search_type">Tipo de Busqueda</label>
                        <select list="search_type" class="form-control" name="search_type" required>
							<option value="credits">Creditos</option>
							<option value="share_payments">Pagos de Cuotas</option>
                        </select>
                        @error('search_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="from">Desde</label>
                        <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}" required>
                        @error('from')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="to">Hasta</label>
                        <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}" required>
                        @error('to')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

				<button type="submit" class="btn btn-primary">Consultar</button>
            </form>

            <form class="mt-3" method="POST" action="/consult/close_day">
                <h4>Cierres de Caja</h4>
                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="from">Desde</label>
                        <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}" required>
                        @error('from')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="to">Hasta</label>
                        <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}" required>
                        @error('to')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Consultar</button>
            </form>
        </div>
    </div>
@endsection