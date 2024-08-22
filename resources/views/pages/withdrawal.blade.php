@extends('layouts.app', ['page' => __('Вывод'), 'pageSlug' => 'withdrawal'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Вывод Средств</h5>
            </div>
            <form method="post" action="{{route('withdrawal.check')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <input name="hash_id" value="{{$user->hash_id}}" hidden>

                    <div class="form-group">
                        <label>На балансе</label>
                        <input type="text" name="send_currency" class="form-control" value="{{$user->balance}}">
                    </div>

                    <div class="form-group">
                        <label>Реквезиты для вывода</label>
                        <input type="text" name="you_send_details" class="form-control" value="{{$user->details_to}}" style="pointer-events: none;">
                    </div>

                    <div class="form-group">
                        <label>Сумма для вывода</label>
                        <input type="text" name="you_send" class="form-control" placeholder="введите сумму для вывода">
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор валюты для вывода</label>
                        <select class="form-control" id="get_currency" name="currency_coin">
                            <option value="USDT">USDT</option>
                            <!-- <option value="XMR">XMR</option> -->
                        </select>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Продолжить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection