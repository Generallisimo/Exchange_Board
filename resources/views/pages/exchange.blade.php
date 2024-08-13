@extends('layouts.app', ['page' => __('Exchange'), 'pageSlug' => 'exchange'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Exchange</h5>
            </div>
            <form method="post" action="{{route('exchange.confirm')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Opinion currency</label>
                        <select class="form-control" id="send_currency" name="send_currency">
                            <option value="BTC">BTC</option>
                            <option value="USDT">USDT</option>
                            <option value="XMR">XMR</option>
                            <option value="RUB">RUB</option>
                            <option value="UAH">UAH</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>You send</label>
                        <input type="text" name="you_send" class="form-control" placeholder="enter amount" value="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Opinion currency</label>
                        <select class="form-control" id="get_currency" name="get_currency">
                            <option value="BTC">BTC</option>
                            <option value="USDT">USDT</option>
                            <option value="XMR">XMR</option>
                            <option value="RUB">RUB</option>
                            <option value="UAH">UAH</option>
                        </select>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection