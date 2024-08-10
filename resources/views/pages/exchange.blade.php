@extends('layouts.app', ['page' => __('Exchange'), 'pageSlug' => 'exchange'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Exchange</h5>
            </div>
            <form method="post" action="#" autocomplete="off">
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Opinion currency</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>BTC</option>
                            <option>USDT</option>
                            <option>XMR</option>
                            <option>RUB</option>
                            <option>UAH</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>You send</label>
                        <input type="text" name="name" class="form-control" placeholder="enter amount" value="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Opinion currency</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>BTC</option>
                            <option>USDT</option>
                            <option>XMR</option>
                            <option>RUB</option>
                            <option>UAH</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>You get</label>
                        <input type="text" class="form-control" placeholder="get amount">
                        </div>
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