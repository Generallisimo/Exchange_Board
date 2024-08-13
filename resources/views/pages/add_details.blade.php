@extends('layouts.app', ['page' => __('Add Details'), 'pageSlug' => 'add details'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Add new details</h5>
            </div>
            <form method="post" action="{{route('create.new.wallets')}}" autocomplete="off">
                @csrf
                <div class="card-body">
                    

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select market</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="hash_id">        
                            @foreach($markets as $market)
                                <option value="{{$market->hash_id}}">{{$market->hash_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select market</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="name_method">        
                            @foreach($methods as $method)
                                <option value="{{$method->name_method}}">{{$method->name_method}} {{$method->currency}}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label>Details for top up</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="details_market_from" class="form-control" placeholder="enter details for top up">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Details for withdrawal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="details_market_to" class="form-control" placeholder="enter details for withdrawal">
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection