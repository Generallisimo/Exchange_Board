@extends('layouts.app', ['page' => __('Транзакции'), 'pageSlug' => 'market board'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="await_but" type="button" class="btn btn-default">Ожидание</button>
                    <button id="success_but" type="button" class="btn btn-default">Успешные</button>
                    <button id="archive_but" type="button" class="btn btn-default">Архивированные</button>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table" id="await">
                <thead>
                    <tr>
                        <th>Exchange ID</th>
                        <th>Сумма</th>
                        <th>Метод оплаты</th>
                        <th>Валюта</th>
                        <th>Реквезиты обменника</th>
                        <th>Статус платежа</th>
                        <th>Процент Обменника</th>
                        <th>Процент Куратора</th>
                        <th>Процент Клиента</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exchanges as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>{{$exchange->amount}} $</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                        <td class="td-actions text-right">
                            <form method="POST" action="{{route('market.success', $exchange->exchange_id)}}">
                                @csrf
                                @method("PUT")
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-check-2"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{route('market.archive', $exchange->exchange_id)}}">
                                @csrf
                                @method("PUT")
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
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
                        <th>Сумма</th>
                        <th>Метод оплаты</th>
                        <th>Валюта</th>
                        <th>Реквезиты обменника</th>
                        <th>Статус платежа</th>
                        <th>Процент Обменника</th>
                        <th>Процент Куратора</th>
                        <th>Процент Клиента</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exchangesSuccess as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>{{$exchange->amount}} $</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="archive" style="display: none;">
            <thead>
                <tr>
                    <th>Exchange ID</th>
                    <th>Сумма</th>
                    <th>Метод оплаты</th>
                    <th>Валюта</th>
                    <th>Реквезиты обменника</th>
                    <th>Статус платежа</th>
                    <th>Процент Обменника</th>
                    <th>Процент Куратора</th>
                    <th>Процент Клиента</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($exchangesArchive as $exchange)
                    <tr>
                        <td>{{$exchange->exchange_id}}</td>
                        <td>{{$exchange->amount}} $</td>
                        <td>{{$exchange->method}}</td>
                        <td>{{$exchange->currency}}</td>
                        <td>{{$exchange->details_market_payment}}</td>
                        <td>{{$exchange->result}}</td>
                        <td>{{$exchange->percent_market}}</td>
                        <td>{{$exchange->percent_agent}}</td>
                        <td>{{$exchange->percent_client}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        const await = document.getElementById('await');
        const success = document.getElementById('success');
        const archive = document.getElementById('archive');
        const await_but = document.getElementById('await_but');
        const archive_but = document.getElementById('archive_but');
        const success_but = document.getElementById('success_but');

        await_but.addEventListener('click', function(){
            await.style.display = 'table';
            archive.style.display = 'none';
            success.style.display = 'none';
        })
        archive_but.addEventListener('click', function(){
            await.style.display = 'none';
            archive.style.display = 'table';
            success.style.display = 'none';
        })
        success_but.addEventListener('click', function(){
            archive.style.display = 'none';
            success.style.display = 'table';
            await.style.display = 'none';
        })


    })
</script>
@endsection