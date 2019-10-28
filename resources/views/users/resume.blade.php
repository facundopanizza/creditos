@extends('layouts.app')

@section('title', 'Resumen')

@section('main')
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Numero Actividad</th>
                <th scope="col">Tipo de Actividad</th>
                <th scope="col">Plata</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $money = 0;
            ?>
            @foreach ($user->credits as $credit)
                @foreach ($credit->shares as $share)
                    @if(!empty($share->payment))
                        <?php
                            $money = $money + $share->payment->payment_amount;
                        ?>
                        <tr>
                            <td>{{ $share->payment->id }}</td>
                            <td>Pago de Cuota</td>
                            <td>{{ $share->payment->payment_amount }}</td>
                            <td>{{ $share->payment->created_at }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            @foreach ($user->credits as $credit)
                <?php
                    $money = $money - $credit->money;
                ?>
                <tr>
                    <td>{{ $credit->id }}</td>
                    <td>Prestamo</td>
                    <td>{{ $credit->money }}</td>
                    <td>{{ $credit->created_at }}</td>
                </tr>
            @endforeach
            @foreach ($user->cash_allocation as $cash_allocation)
                <?php
                    $money = $money + $cash_allocation->money;
                ?>
                <tr>
                    <td>{{ $cash_allocation->id }}</td>
                    <td>Plata Entregada</td>
                    <td>{{ $cash_allocation->money }}</td>
                    <td>{{ $cash_allocation->created_at }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Total: {{ $money }}</td>
            </tr>
        </tbody>
    </table>
@endsection