@extends('layouts.app')

@section('title', 'Resumen')

@section('main')
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero Actividad</th>
                <th scope="col">Cliente</th>
                <th scope="col">Tipo de Actividad</th>
                <th scope="col">Plata</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $money = 0;
                $share_payment =  0;
                $credit_sub = 0;
                $allocated_sub = 0;
            ?>
            @foreach ($user->credits as $credit)
                @foreach ($credit->shares as $share)
                    @if(!empty($share->payment))
                        <?php
                            $money = $money + $share->payment->payment_amount;
                            $share_payment = $share_payment + $share->payment->payment_amount;
                        ?>
                        <tr>
                            <td>{{ $share->payment->id }}</td>
                            <td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
                            <td>Pago de Cuota</td>
                            <td>+{{ $share->payment->payment_amount }}</td>
                            <td>{{ $share->payment->created_at }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr>
                <td colspan="4">Subtotal: {{ $share_payment }}</td>
            </tr>
            @foreach ($user->credits as $credit)
                <?php
                    $money = $money - $credit->money;
                    $credit_sub = $credit_sub - $credit->money;
                ?>
                <tr>
                    <td>{{ $credit->id }}</td>
                    <td>{{ $credit->client->first_name . ' ' . $credit->client->last_name }}</td>
                    <td>Prestamo</td>
                    <td>-{{ $credit->money }}</td>
                    <td>{{ $credit->created_at }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Subtotal: {{ $credit_sub }}</td>
            </tr>
            @foreach ($user->cash_allocation as $cash_allocation)
                <?php
                    $money = $money + $cash_allocation->money;
                    $allocated_sub = $allocated_sub + $cash_allocation->money;
                ?>
                <tr>
                    <td>{{ $cash_allocation->id }}</td>
                    <td></td>
                    <td>Plata Entregada</td>
                    <td>+{{ $cash_allocation->money }}</td>
                    <td>{{ $cash_allocation->created_at }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Subtotal: {{ $allocated_sub }}</td>
            </tr>
            <tr>
                <td colspan="4">Total: {{ $money }}</td>
            </tr>
        </tbody>
    </table>
@endsection