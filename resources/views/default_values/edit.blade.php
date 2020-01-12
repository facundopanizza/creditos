@extends('layouts.app')

@section('title', 'Cambiar Default')

@section('main')
    <div class="card">
        <div class="card-header">Cambiar Default de Valor Maximo de Credito</div>
        <div class="card-body">
            <form method="POST" action="/defaults/maximum_credit">
                @csrf
                @method('PUT')

                <div class="form-group col-md-6">
                    <label for="value">Valor maximo de total de creditos default: </label>
                    <input type="text" class="form-control" name="value"  value="{{ $maximumCredit->value }}" required>
                    <button class="btn btn-primary mt-3">Cambiar</button>
                </div>
            </form>
        </div>
    </div>
@endsection