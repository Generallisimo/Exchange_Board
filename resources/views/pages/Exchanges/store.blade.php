@extends('layouts.payments.app')


@section('content')
    <div class="row">
        <div class="col-md-6" style="margin: 100px auto;">
            <div class="card">
                <input hidden name="exchange_id" value="{{$exchange_id}}">
                <div class="card-header">
                    <h5 class="title text-center">Статус платежа</h5>
                </div>
                <div class="status">
                    <h1 class="status-text text-center">Платеж обрабатывается</h1>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.apiUrl = "{{ config('app.api_local') }}";
    </script>
    <script src="{{ asset('js') }}/CheckStatusExchange/CheckStatus.js"></script>
@endsection