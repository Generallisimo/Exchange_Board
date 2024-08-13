@extends('layouts.app', ['page' => __('Withdrawal'), 'pageSlug' => 'withdrawal'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Withdrawal</h5>
            </div>
            <form method="post" action="#" autocomplete="off">
                <div class="card-body">

                    <div class="form-group">
                        <label>You have</label>
                        <input type="text" name="send_currency" class="form-control" placeholder="enter amount" value="{{$user->balance}}">
                    </div>

                    <div class="form-group">
                        <label>Withdrawal amount</label>
                        <input type="text" name="you_send" class="form-control" placeholder="enter amount">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Opinion currency</label>
                        <select class="form-control" id="get_currency" name="get_currency">
                            <option value="USDT">USDT</option>
                            <option value="XMR">XMR</option>
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