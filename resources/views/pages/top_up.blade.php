@extends('layouts.app', ['page' => __('Top Up'), 'pageSlug' => 'top up'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Top Up</h5>
            </div>
            <form method="post" action="#" autocomplete="off">
                <div class="card-body">

                    <div class="form-group">
                        <label>You send</label>
                        <input type="text" name="send_currency" class="form-control" placeholder="enter amount" value="">
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