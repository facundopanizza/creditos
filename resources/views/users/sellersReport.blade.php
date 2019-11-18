@extends('layouts.app')

@section('title', 'Reporte de Vendedores')

@section('main')
<div class="card">
    <div class="card-header">
        Pedir Reporte de Vendedores
    </div>
    <div class="card-body">
        <form method="POST" action="/sellers-report/find-report">
            @csrf

            <div class="form-group">
                <label for="exampleInputEmail1">Desde:</label>
                <input type="date" class="form-control" name="from" value="{{ old('from') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Hasta:</label>
                <input type="date" class="form-control" name="until" value="{{ old('until') }}">
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>
    </div>
</div>
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Vendedor</th>
        <th scope="col">Cobrado</th>
        <th scope="col">Comision</th>
    </tr>
</thead>
<tbody>
    @empty($sellers)
        <tr>
            <td colspan="3" class="text-danger">
                No hay registros entre esas fechas
            </td>
        </tr>
    @else
        @foreach($sellers as $seller)
        <?php
            $payed = 0;
        ?>
        @foreach($seller['credits'] as $credit)
        <?php
            $payed += $credit['payed'];
        ?>
        @endforeach
        <tr>
            <td>{{ $seller['seller']->first_name . ' ' . $seller['seller']->last_name }}</td>
            <td>{{ $payed }}</td>
            <td>{{ $payed * 2 / 100 }}</td>
        </tr>
    @endforeach
    @endif
</tbody>
</table>
@endsection