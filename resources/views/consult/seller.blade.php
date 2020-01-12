@extends('layouts.app')

@section('title', 'Resultados')

@section('main')
@if($searchType == 'credits')
    @component('consult.credits', ['results' => $results])
    @endcomponent
@elseif($searchType == 'share_payments')
    @component('consult.share_payments', ['results' => $results])
    @endcomponent
@elseif($searchType == 'payments_to_seller')
    @component('consult.payments_to_seller', ['results' => $results])
    @endcomponent
@elseif($searchType == 'money_received_from_seller')
    @component('consult.money_received_from_seller', ['results' => $results])
    @endcomponent
@endif
@endsection