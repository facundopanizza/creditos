@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('main')
    <div class="card">
        <div class="card-header">
            Editar Cliente
        </div>
        <div class="card-body">
            <form method="POST" action="/clients/{{ $client->id }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first_name">Nombre</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Juan" value="{{ $client->first_name }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Perez" value="{{ $client->last_name }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="phone">Numero de Telefono</label>
                        <input type="text" class="form-control" name="phone" placeholder="12345678" value="{{ $client->phone }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cell_phone">Numero de Celular</label>
                        <input type="text" class="form-control" name="cell_phone" placeholder="12345678" value="{{ $client->cell_phone }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="activity">Actividad</label>
                        <input type="text" class="form-control" name="activity" placeholder="Perez" value="{{ $client->activity }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="business_address">Direccion Comercial</label>
                        <input type="text" class="form-control" name="business_address" placeholder="Perez" value="{{ $client->business_address }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="home_address">Dirrecion Personal</label>
                        <input type="text" class="form-control" name="home_address" placeholder="Perez" value="{{ $client->home_address }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" name="dni" placeholder="12345678" value="{{ $client->dni }}" required>
                    </div>
                </div>

				@if(Auth::user()->role === 'admin')
				<div class="row">
                    <div class="form-group col-md-6">
                        <label for="maximum_credit">Limite de cantidad de dinero a prestar en total</label>
                        <input type="number" class="form-control" name="maximum_credit" placeholder="12345678" value="{{ $client->maximum_credit }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="seller_id">Vendedor Asignado</label>
                        <select list="seller_id" class="form-control" name="seller_id" value="{{ $client->seller_id }}" required>
						@foreach($sellers as $seller)
							<option value="{{ $seller->id }}" @if($seller->id == $client->seller_id) selected @endif>
								{{ $seller->first_name . ' ' . $seller->last_name }}
							</option>
						@endforeach
						</select>
                    </div>
                </div>

				<div class="row">
                    <div class="form-group col-md-6">
                        <label for="multi_credit">Multi Credito</label>
                        <select class="form-control" name="multi_credit" value="{{ $client->multi_credit }}" required>
                            @if($client->multi_credit == 0)
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            @else
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cancel_with_other_credit">Cancelar credito anterior con nuevo credito</label>
                        <select class="form-control" name="cancel_with_other_credit" required>
                            @if($client->cancel_with_other_credit == 0)
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            @else
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            @endif
                        </select>
                    </div>
                </div>
				@endif
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
        </div>
    </div>
@endsection
