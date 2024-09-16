@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="container">
        <!-- Раздел 1: Баланс -->
        <div class="row mb-4">
            <div class="col-12">
                <h3>Баланс</h3>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Баланс кошелька</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{$data['user']->balance}} USDT</h3>
                    </div>
                </div>
            </div>
       
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Кошелёк пополнения</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{$data['user']->details_from}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Кошелёк вывода</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{$data['user']->details_to}}</h3>
                    </div>
                </div>
            </div>
        </div>
        @if($data['client'] !== null)
        <div class="row mb-4">
            <div class="col-12">
                <h3>Ключи для оплат</h3>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">API ключ</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{config('url.api_local')}}/api/pay/{currency}/{amount}/{{$data['client']->api_key}}</h3>
                    </div>
                </div>
            </div>
       
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">API ссылка</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{config('url.api_local')}}/api/payment/{{$data['client']->api_link}}/{amount}/{currency}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Auth::user()->hasRole('admin'))
        <div class="row mb-4">
            <div class="col-12">
                <h3>Статистика балансов</h3>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Общий баланс обменников</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{$data['sumMarket']}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Общий баланс клиентов</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{$data['sumClient']}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Общий баланс кураторов</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['sumAgent']}} </h3>
                </div>
            </div>
        </div>
        @endif


        <div class="row">
            <div class="col-12">
                <h3>Статистика оборота</h3>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="timePeriod">Выберите период:</label>
                    <select id="timePeriod" class="form-control">
                        <option value="day">День</option>
                        <option value="week">Неделя</option>
                        <option value="month">Месяц</option>
                        <option value="year">Год</option>
                    </select>
                </div>
                <canvas id="turnoverChart" width="400" height="200"></canvas>
            </div>
        </div>

        @if(Auth::user()->hasRole('admin'))
        <div class="row mb-4">
            <div class="col-12">
                <h3>Обменники</h3>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Обменники онлайн</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['marketOnlineCount']}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <ul>
                                @if($data['marketOnline']->isEmpty())
                                    <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                                @else
                                    @foreach($data['marketOnline'] as $market)
                                        <li style="list-style: auto; color: #cfcdcd;">{{$market->hash_id}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Обменники офлайн</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['marketOfflineCount']}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <ul>
                                @if($data['marketOffline']->isEmpty())
                                    <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                                @else
                                    @foreach($data['marketOffline'] as $market)
                                        <li style="list-style: auto; color: #cfcdcd;">{{$market->hash_id}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-12">
                <h3>Статистика заявок</h3>
            </div>
            <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Количество заявок в обработке</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['exchangeAwaitCount']}} </h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <ul>
                            @if($data['exchangeAwait']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeAwait'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список диспутов</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['exchangeDisputeCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <ul>
                            @if($data['exchangeDispute']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeDispute'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{ $exchange->exchange_id }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список архива</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['exchangeArchiveCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <ul>
                            @if($data['exchangeArchive']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeArchive'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex mb-4">
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список успешных</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['exchangeSuccessCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <ul>
                            @if($data['exchangeSuccess']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeSuccess'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список транзакций с ошибками</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i>{{$data['exchangeErrorCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <ul>
                            @if($data['exchangeError']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeError'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

        <input hidden value="{{$data['user']->hash_id}}" id="hash_id">
    </div>
@endsection




@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('js') }}/PeriodDashboard/period.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
