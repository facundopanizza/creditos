@extends('layouts.app')

@section('title', 'Nuevo Credito')

@section('main')
    <div class="card">
        <div class="card-header">
            Nuevo Credito
        </div>

        @if(!empty($client->id))
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <span class="text-secondary">Numero de Cliente:</span> {{ $client->id }}
                    </div>

                    <div class="col-md-3">
                        <span class="text-secondary">Nombre:</span> {{ $client->first_name }}
                    </div>

                    <div class="col-md-3">
                        <span class="text-secondary">Apellido:</span> {{ $client->last_name }}
                    </div>

                    <div class="col-md-3">
                        <span class="text-secondary">DNI:</span> {{ $client->dni }}
                    </div>
                </div> 

                <form method="POST" action="/credits">
                    @csrf

                    <div class="form-group">
                        <input type="hidden" class="form-control" name="client_id" value="{{ $client->id }}">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="money">Monto a Prestar</label>
                            <input id="money" type="number" class="form-control" name="money">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="interest_rate">Porcentaje de Interes</label>
                            <div class="row">
                                <div class="col-md-11">
                                    <input id="interest" type="number" class="form-control" name="interest_rate">
                                </div>
                                <div class="col-md-1">%</div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="period">Período</label>
                            <select id="period" class="form-control" name="period">
                                <option value="30">Diario (30 Cuotas)</option>
                                <option value="4">Semanal (4 Cuotas)</option>
                                <option value="2">Quincenal (2 Cuotas)</option>
                                <option value="1">Mensual (1 Cuota)</option>
                            </select>
                        </div>
                    </div>

                    <div id="shareDiv" class="form-group" style="display: none">
                        <label for="share">Valor Cuota</label>
                        <input class="form-control" id="share" type="number" readonly>
                    </div>

                    <button type="button" id="calculate" class="btn btn-secondary mb-4">Calcular</button>

                    <button type="submit" id="submit" class="btn btn-primary" style="display: none">Crear Prestamo</button>
                </form>


                <script>
                    let calculate = document.querySelector('#calculate');
                    let submit = document.querySelector('#submit');
                    let share = document.querySelector('#share');
                    let shareDiv = document.querySelector('#shareDiv');
                    let money = document.querySelector('#money')
                    let interest = document.querySelector('#interest')
                    let period = document.querySelector('#period');

                    calculate.onclick = function() {
                        let shareValue = Number(((interest.value * money.value) / 100)) + Number(money.value);
                        share.value = shareValue / Number(period.value);
                        shareDiv.style.display = 'block';
                        submit.style.display = 'block';
                    }
                </script>
            </div>
        @else
        <div class="card-body">
            <form class="mb-4" method="POST" action="/search/clients">
                @csrf

                <div class="form-group">
                    <label for="first_name">Nombre</label>
                    <input name="first_name" type="text" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <form class="mb-4" method="POST" action="/search/clients">
                @csrf

                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    <input name="last_name" type="text" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <form class="mb-4" method="POST" action="/search/clients">
                @csrf

                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input name="dni" type="number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        @endif
    </div>
@endsection