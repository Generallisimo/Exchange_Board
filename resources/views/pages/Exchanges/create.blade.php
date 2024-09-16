@extends('layouts.payments.app')


@section('content')
    <div class="row">
        <div class="col-md-6" style="margin: 100px auto;">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>Произошла ошибка, обратитесь в поддержку</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h5 class="title text-center">Подтверждение платежа</h5>
                </div>
                <form method="POST" action="{{route('payment.store', ['exchange_id'=>$result['exchange_id']])}}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                    
                    <input hidden name="client_id" value="{{$result['client']}}">
                    <input hidden name="market_id" value="{{$result['market']}}">
                    <input hidden name="agent_id" value="{{$result['agent']}}">
                    <input hidden name="amount" value="{{$result['amount']}}">
                    <input hidden name="percent_client" value="{{$result['percent_client']}}">
                    <input hidden name="percent_market" value="{{$result['percent_market']}}">
                    <input hidden name="percent_agent" value="{{$result['percent_agent']}}">
                    <input hidden name="method" value="{{$result['method']}}">
                    <input hidden name="currency" value="{{$result['currency']}}">
                    <input hidden name="result_client" value="{{$result['result_client']}}">
                    <input hidden name="amount_client" value="{{$result['amount_exchange']}}">
                    <input hidden name="amount_market" value="{{$result['amount_market']}}">
                    <input hidden name="amount_agent" value="{{$result['amount_agent']}}">


                    <div class="form-group">
                        <label for="exampleInputEmail1">Сумма к отправлению</label>
                        <input  class="form-control" name="amount_users" value="{{$result['amount_users']}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Адресс получателя</label>
                        <input  class="form-control" name="details_market_payment" value="{{$result['wallet_market']['details_market_to']}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Комментарий от получателя</label>
                        <input  class="form-control" value="{{$result['wallet_market']['comment']}}" style="pointer-events: none;">
                    </div>
                        
                    <div class="form-group">
                        <label for="photo">Загрузить фото подтверждения</label>
                        <input type="file" class="form-control" name="photo">
                    </div>
                    @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-fill btn-primary">Оплатил</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection