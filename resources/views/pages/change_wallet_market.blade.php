@extends('layouts.app', ['page' => __('Change wallet for market'), 'pageSlug' => 'change wallet for market'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Change wallet for market</h5>
            </div>
            <form method="post" action="{{route('user.update.change.details', $market_details->id)}}" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="card-body">

                        <div class="form-group">
                            <label>Hash ID</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="hash_id" class="form-control" value="{{$market_details->hash_id}}" style="pointer-events: none;">
                        </div>

                        <div class="form-group">
                            <label>Details for top up</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_from" class="form-control" value="{{$market_details->details_market_from}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Details for withdrawal </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_to" class="form-control" value="{{$market_details->details_market_to}}">
                            </div>
                        </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection