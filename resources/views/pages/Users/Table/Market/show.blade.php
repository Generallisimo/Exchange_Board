@extends('layouts.app', ['page' => __('Кошелек обменника'), 'pageSlug' => 'wallets market'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            <div class="card-header">
                <h5 class="title">Кошелек обменника - {{$hash_id}}</h5>
            </div>
            <form method="post" action="{{route('table.user.market.update', ['hash_id'=>$hash_id])}}" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="card-footer">
                    <button class="btn btn-primary btn-round">{{$data['market']['status']}}</button>
                </div>
            </form>
            <table class="table" id="agents">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Реквезиты получения</th>
                        <th>Статус</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['market_details'] as $market_detail)
                    <tr>
                        <td>{{$market_detail->id}}</td>
                        <td>{{$market_detail->details_market_to}}</td>
                        <td>{{$market_detail->online}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('table.user.market.edit', ['id'=>$market_detail->id]) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
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
@endsection