@extends('layouts.app', ['page' => __('Request change'), 'pageSlug' => 'request change'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Request change</h5>
            </div>
            <form method="post" action="#" autocomplete="off">
                <div class="card-body">

                    <div class="form-group">
                        <label>You currency</label>
                        <input type="text" name="send_currency" class="form-control" placeholder="enter amount" value="{{$send_currency}}">
                    </div>

                    <div class="form-group">
                        <label>You send</label>
                        <input type="text" name="you_send" class="form-control" placeholder="enter amount" value="{{$you_send}}">
                    </div>

                    <div class="form-group">
                        <label>Get currency</label>
                        <input type="text" name="get_currency" class="form-control" placeholder="enter amount" value="{{$get_currency}}">
                    </div>

                    <div class="form-group">
                        <label>You get</label>
                        <input type="text" name="you_get" class="form-control" placeholder="get amount" value="{{$response}}">
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