@extends('layouts.app')

@section('title', 'Cajas Cerradas')

@section('main')
<table class="table table-hover">
<thead>
    <tr>
        <th scope="col">Monto Inicial</th>
        <th scope="col">Monto Final</th>
        <th scope="col">Hora de Apertura de Caja</th>
        <th scope="col">Hora de Cierre de Caja</th>
    </tr>
</thead>
<tbody>
    @foreach($closed_days->sortByDesc('created_at') as $closed_day)
    <tr>
        <td>{{ $closed_day->initialCash->entry_money }}</td>
        <td>{{ $closed_day->money }}</td>
        <td>{{ $closed_day->initialCash->created_at }}</td>
        <td>{{ $closed_day->created_at }}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endsection