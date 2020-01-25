@extends('layouts.app')

@section('title', 'Informar Pago')

@section('main')
    <div class="card">
        <div class="card-header">
            Informar Pago
        </div>
        <div class="card-body">
            <form method="POST" action="/shares/{{ $share->id }}/share_payments">
                @csrf

                <input type="hidden" name="share_id" value="{{ $share->id }}">
                <div>
                    <div class="form-group col-md">
                        <label for="share_price">Precio Cuota</label>
                        <input id="share_price" type="text" class="form-control" value="{{ $share->money }}" readonly>
                    </div>
                    <div class="form-group col-md">
                        <?php
                            if($share->payments->count() != 0) {
                                $payed = 0;

                                foreach($share->payments as $payment) {
                                    $payed += $payment->payment_amount;
                                }
                            } else {
                                $payed = 0;
                            }
                        ?>
                        <input id="payed" type="hidden" class="form-control" value="{{ $payed }}" readonly>
                    </div>
                    <div class="form-group col-md">
                        <label for="payment_amount">Cantidad del Pago</label>
                        <input id="payment_amount" type="number" class="form-control @error('payment_amount') is-danger @enderror" name="payment_amount" value="{{ old('payment_amount') }}" required>
                        @error('payment_amount')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="debt">Deuda</label>
                        <input type="text" class="form-control" id="debt" value="{{ $share->money - $payed }}" readonly>
                    </div>
                </div>

                <button id="calculate" type="button" class="btn btn-secondary mb-4">Calcular</button>
                <button id="pay-all" type="button" class="btn btn-secondary mb-4">Pagar Restante</button>
                <button id="submit" type="submit" class="btn btn-primary" style="display: none">Crear Pago</button>
            </form>

            <script>
                let submit = document.querySelector('#submit');
                let calculate = document.querySelector('#calculate');
                let pay_all = document.querySelector('#pay-all');
                let debt = document.querySelector('#debt');
                let share_price = document.querySelector('#share_price');
                let payed = document.querySelector('#payed');

                calculate.onclick = function() {
                    let payment_amount = document.querySelector('#payment_amount');
                    debt.value = Number(share_price.value) - Number(payment_amount.value) - Number(payed.value);
                    submit.style.display = 'block';
                }

                pay_all.onclick = function() {
                    let payment_amount = document.querySelector('#payment_amount');
                    payment_amount.value = Number(share_price.value) - Number(payed.value);
                    debt.value = Number(share_price.value) - Number(payment_amount.value) - Number(payed.value);
                    submit.style.display = 'block';
                }
            </script>
        </div>
    </div>
@endsection