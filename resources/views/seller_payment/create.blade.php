@extends('layouts.app')

@section('title', 'Pagar a Vendedor')

@section('main')
    <div class="card">
        <div class="card-header">
            Pagar a Vendedor
        </div>
        <div class="card-body">
            <form method="POST" action="/users/{{ $seller->id }}/payments">
                @csrf

                <div class="form-group col-md-6">
                    <label for="money">Plata: </label>
                    <input type="text" class="form-control" value="{{ $seller->payment }}" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Pagar</button>
            </form>



            @if(!empty($seller->payments->first()))
            <h3 class="my-3">Pagos</h3>
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Monto</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seller->payments as $payment)
                <tr>
                    <td>{{ $payment->payment_amount }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection