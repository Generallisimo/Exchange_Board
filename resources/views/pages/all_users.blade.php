@extends('layouts.app', ['page' => __('Все пользователи'), 'pageSlug' => 'all users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="markets_but" type="button" class="btn btn-default">Обменники</button>
                    @if(Auth::user()->hasRole('admin'))
                    <button id="clients_but" type="button" class="btn btn-default">Клиенты</button>
                    <button id="agents_but" type="button" class="btn btn-default">Кураторы</button>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
            <table class="table" id="clients" style="display: none;">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Приватный ключ</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th>API ключ</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->hash_id}}</td>
                        <td>{{$client->percent}} %</td>
                        <td>{{$client->details_from}}</td>
                        <td>{{$client->private_key}}</td>
                        <td>{{$client->details_to}}</td>
                        <td>{{$client->balance}}</td>
                        <td>{{$client->api_link}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('user.update.check', $client->hash_id) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('user.delete', $client->hash_id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="agents" style="display: none;">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Приватный ключ</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td>{{$agent->hash_id}}</td>
                        <td>{{$agent->percent}} %</td>
                        <td>{{$agent->details_from}}</td>
                        <td>{{$agent->private_key}}</td>
                        <td>{{$agent->details_to}}</td>
                        <td>{{$agent->balance}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('user.update.check', $agent->hash_id) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('user.delete', $agent->hash_id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="markets">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Статус</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Приватный ключ</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th>Кошелек</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($markets as $market)
                    <tr>
                        <td>{{$market->hash_id}}</td>
                        <td>{{$market->status}}</td>
                        <td>{{$market->percent}} %</td>
                        <td>{{$market->details_from}}</td>
                        <td>{{$market->private_key}}</td>
                        <td>{{$market->details_to}}</td>
                        <td>{{$market->balance}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{route('user.update.check.details', $market->hash_id)}}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                    <i class="tim-icons icon-single-02"></i>
                                </button>
                            </form>
                        </td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('user.update.check', $market->hash_id) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('user.delete', $market->hash_id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        // if (typeof Echo !== 'undefined') {
        //     Echo.channel('board-change')
        //         .listen('.board-change', res => {
        //             console.log(res.users )
        //             console.log(res.isOnline )
        //             const userElement = document.getElementById(`market-${res.users.hash_id}`);
        //             // Теперь используйте правильную структуру данных
        //             console.log(userElement )
        //             if (userElement) {
        //                 console.log(`Before update: ${userElement.innerText}`); // Лог перед обновлением
        //                 userElement.innerText = res.isOnline ? 'Online' : 'Offline';
        //                 console.log(`After update: ${userElement.innerText}`);
        //             } else {
        //                 console.error(`Element with ID market-${res.users.hash_id} not found.`);
        //             }
        //         })
        // } else {
        //     console.error('Echo is not defined');
        // }
        
        
        // Остальной код для переключения таблиц
        const clients = document.getElementById('clients');
        const agents = document.getElementById('agents');
        const markets = document.getElementById('markets');
        const clientsBut = document.getElementById('clients_but');
        const agentsBut = document.getElementById('agents_but');
        const marketsBut = document.getElementById('markets_but');

        clientsBut.addEventListener('click', function(){
            clients.style.display = 'table';
            markets.style.display = 'none';
            agents.style.display = 'none';
        });

        agentsBut.addEventListener('click', function(){
            clients.style.display = 'none';
            markets.style.display = 'none';
            agents.style.display = 'table';
        });

        marketsBut.addEventListener('click', function(){
            clients.style.display = 'none';
            markets.style.display = 'table';
            agents.style.display = 'none';
        });

    });
</script>
@endsection