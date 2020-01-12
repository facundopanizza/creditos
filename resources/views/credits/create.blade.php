@extends('layouts.app')

@section('title', 'Nuevo Credito')

@section('main')
    <div class="card">
        <div class="card-header">
            Nuevo Credito
        </div>
        @if(isset($errorMessage))
        <div class="card-header bg-danger text-white">
            {{ $errorMessage }}
        </div>
        @endif

        @error('credit_to_cancel')
        <div class="card-header bg-danger text-white">
            {{ $message }}
        </div>
        @enderror

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
                            <input id="money" type="number" class="form-control @error('money') is-invalid @enderror" name="money" value="{{ old('money') }}">
                            @error('money')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="interest_rate">Porcentaje de Interes</label>
                            <div class="row">
                                <div class="col-md-11">
                                    <input id="interest" type="number" class="form-control" name="interest_rate" value="{{old('interest_rate') !== null ? old('interest_rate') : 40 }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="daily">Diarios</label>
                            <select id="daily" class="form-control" name="daily">
                                <option value="21">21</option>
                                <option value="28">28</option>
                                <option value="42">42</option>
                                <option value="56">56</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="maximum_credit">Monto maximo de credito</label>
                            <input id="maximum_credit" class="form-control" value="{{ $client->maximum_credit }}" readonly>
                        </div>

                        <div id="all" class="form-group col-md-4" style="display: none">
                            <label for="period">Período</label>
                            <select id="period-all" class="form-control" name="">
                                <option value="1">Diario</option>
                                <option value="7">Semanal</option>
                                <option value="14">Quincenal</option>
                                <option value="28">Mensual</option>
                            </select>
                        </div>

                        <div id="weekly" class="form-group col-md-4">
                            <label for="period">Período</label>
                            <select id="period-weekly" class="form-control" name="period">
                                <option value="1">Diario</option>
                                <option value="7">Semanal</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div id="shareDiv" class="form-group col-md" style="display: none">
                            <label for="share">Valor Cuota</label>
                            <input class="form-control" id="share" type="number" readonly>
                        </div>
                        <div id="shares-div" class="form-group col-md" style="display: none">
                            <label for="share">Cuotas</label>
                            <input class="form-control" id="shares-input" type="number" readonly>
                        </div>
                    </div>

                    @if(isset($credits))
                    @empty($credits->first())

                    @else
                        <h4>Cancelar Credito Previo</h4>
                        @foreach($credits as $credit)
                        <?php
                            $debt = 0;
                            foreach($credit->shares as $share) {
                                if($share->share_cancelled !== 1) {
                                    $payed = 0;
                                    foreach($share->payments as $payment) {
                                        $payed += $payment->payment_amount;
                                    }
                                    $debt += $share->money - $payed;
                                }
                            }

                        ?>
                        <div class="form-group">
                            <input type="radio" name="cancel_credit" value="{{ $credit->id }}">
                            <label for="cancel_credit" value="{{ $credit->id }}">Deuda: {{ $debt }} <a href="/credits/{{ $credit->id }}">Ver credito</a></label>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <input type="radio" name="cancel_credit" value="null">
                            <label for="cancel_credit" value="null">Ninguno</label>
                        </div>
                    @endif
                    @endif

                    <button type="button" id="calculate" class="btn btn-secondary mb-4">Calcular</button>

                    <button type="submit" id="submit" class="btn btn-primary" style="display: none">Crear Prestamo</button>
                </form>

                <script>
                    let calculate = document.querySelector('#calculate');
                    let submit = document.querySelector('#submit');
                    let share = document.querySelector('#share');
                    let shareDiv = document.querySelector('#shareDiv');
                    let money = document.querySelector('#money');
                    let interest = document.querySelector('#interest');
                    let period = document.querySelector('#period');
                    let daily = document.querySelector('#daily');
                    let all = document.querySelector('#all');
                    let period_all = document.querySelector('#period-all');
                    let weekly = document.querySelector('#weekly');
                    let period_weekly = document.querySelector('#period-weekly');

                    calculate.onclick = function() {
                        let interest = document.querySelector('#interest');
                        let daily = document.querySelector('#daily');
                        let period_weekly = document.querySelector('#period-weekly');
                        let period_all = document.querySelector('#period-all');
                        let money = document.querySelector('#money');
                        let shares_input = document.querySelector('#shares-input');
                        let shares_div = document.querySelector('#shares-div');
                        let period;
                        let shares;

                        if(daily.value == 21 || daily.value == 42) {
                            if(period_weekly.value == 1) {
								shares = Number(daily.value);
                                /* switch(Number(daily.value)) { */
                                /*     case 21: */
                                /*         shares = 21 - 6; */
                                /*         break; */
                                /*     case 42: */
                                /*         shares = 42 - 12; */
                                /*         break; */
                                /* } */
                            } else {
                                shares = Number(daily.value) / Number(period_weekly.value);
                            }
                        } else {
                            if(period_all.value == 1) {
								shares = Number(daily.value)
                                /* switch(Number(daily.value)) { */
                                /*     case 28: */
                                /*         shares = 28 - 8; */
                                /*         break; */
                                /*     case 56: */
                                /*         shares = 56 - 16; */
                                /*         break; */
                                /* } */
                            } else {
                                shares = Number(daily.value) / Number(period_all.value);
                            }
                        }

                        let interest_final = (Number(interest.value) / 28) * Number(daily.value);
                        let profit = (Number(money.value) * interest_final) / 100;

                        share.value = Math.ceil((profit + Number(money.value)) / shares);
                        shares_input.value = shares;
                        shares_div.style.display = "block";
                        shareDiv.style.display = 'block';
                        submit.style.display = 'block';
                    }

                    daily.onchange = function() {
                        if(daily.value == 21 || daily.value == 42) {
                            weekly.style.display = 'block';
                            all.style.display = 'none';
                            period_weekly.setAttribute('name', 'period');
                            period_all.setAttribute('name', '');
                        } else {
                            weekly.style.display = 'none';
                            all.style.display = 'block';
                            period_weekly.setAttribute('name', '');
                            period_all.setAttribute('name', 'period');
                        }
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
