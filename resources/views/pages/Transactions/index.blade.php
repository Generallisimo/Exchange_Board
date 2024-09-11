@extends('layouts.app', ['page' => __('Транзакции'), 'pageSlug' => 'market board'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if(session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            @if($errors->has('transactions_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('transactions_error') }}
                </div>
            @endif
            <div class="card-header">
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="await_but" type="button" class="btn btn-default">Ожидание</button>
                    <button id="dispute_but" type="button" class="btn btn-default">Диспуты</button>
                    <button id="success_but" type="button" class="btn btn-default">Успешные</button>
                    <button id="archive_but" type="button" class="btn btn-default">Архивированные</button>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table" id="await">
                <thead>
                    <tr>
                        <th>Exchange ID</th>
                        <th>Фото подтверждения</th>
                        <th>Сумма</th>
                        <th>Метод оплаты</th>
                        <th>Валюта</th>
                        <th>Реквезиты обменника</th>
                        <th>Статус платежа</th>
                        <th>Процент Обменника</th>
                        <th>Заработок Обменника</th>
                        <th>Процент Куратора</th>
                        <th>Заработок Куратора</th>
                        <th>Процент Клиента</th>
                        <th>Заработок Клиента</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['exchanges'] as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>
                            <img src="{{ asset($exchange->photo) }}" alt="Фото подтверждения" style="max-width: 150px; max-height: 150px;">
                        </td>
                        <td>{{$exchange->amount_users}}</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->amount_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->amount_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                        <td>{{$exchange->amount_client}}</td>
                        <td class="td-actions text-right">
                            <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'to_success', 'message'=>'Ожидания получения суммы'])}}">
                                @csrf
                                @method("PUT")
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-check-2"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'archive', 'message'=>'Архивировано, обратится в поддержку'])}}">
                                @csrf
                                @method("PUT")
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'dispute', 'message'=>'Отправлено на спор'])}}">
                                @csrf
                                @method("PUT")
                                <button type="submit" rel="tooltip" class="btn btn-warning btn-sm btn-icon">
                                    <i class="tim-icons icon-chat-33"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="success" style="display: none;">
                <thead>
                <tr>
                        <th>Exchange ID</th>
                        <th>Фото подтверждения</th>
                        <th>Сумма</th>
                        <th>Метод оплаты</th>
                        <th>Валюта</th>
                        <th>Реквезиты обменника</th>
                        <th>Статус платежа</th>
                        <th>Процент Обменника</th>
                        <th>Заработок Обменника</th>
                        <th>Процент Куратора</th>
                        <th>Заработок Куратора</th>
                        <th>Процент Клиента</th>
                        <th>Заработок Клиента</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['exchangesSuccess'] as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>
                            <img src="{{ asset($exchange->photo) }}" alt="Фото подтверждения" style="max-width: 150px; max-height: 150px;">
                        </td>
                        <td>{{$exchange->amount_users}}</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->amount_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->amount_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                        <td>{{$exchange->amount_client}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="archive" style="display: none;">
            <thead>
                <tr>
                    <th>Exchange ID</th>
                    <th>Фото подтверждения</th>
                    <th>Сумма</th>
                    <th>Метод оплаты</th>
                    <th>Валюта</th>
                    <th>Реквезиты обменника</th>
                    <th>Статус платежа</th>
                    <th>Процент Обменника</th>
                    <th>Заработок Обменника</th>
                    <th>Процент Куратора</th>
                    <th>Заработок Куратора</th>
                    <th>Процент Клиента</th>
                    <th>Заработок Клиента</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data['exchangesArchive'] as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>
                            <img src="{{ asset($exchange->photo) }}" alt="Фото подтверждения" style="max-width: 150px; max-height: 150px;">
                        </td>
                        <td>{{$exchange->amount_users}}</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->amount_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->amount_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                        <td>{{$exchange->amount_client}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="dispute" style="display: none;">
            <thead>
                <tr>
                    <th>Exchange ID</th>
                    <th>Фото подтверждения</th>
                    <th>Сумма</th>
                    <th>Метод оплаты</th>
                    <th>Валюта</th>
                    <th>Реквезиты обменника</th>
                    <th>Статус платежа</th>
                    <th>Процент Обменника</th>
                    <th>Заработок Обменника</th>
                    <th>Процент Куратора</th>
                    <th>Заработок Куратора</th>
                    <th>Процент Клиента</th>
                    <th>Заработок Клиента</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data['exchangesDispute'] as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>
                            <img src="{{ asset($exchange->photo) }}" alt="Фото подтверждения" style="max-width: 150px; max-height: 150px;">
                        </td>
                        <td>{{$exchange->amount_users}}</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->amount_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->amount_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                        <td>{{$exchange->amount_client}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js') }}/transactions/SelectTransactionsIndex.js"></script>
@endsection