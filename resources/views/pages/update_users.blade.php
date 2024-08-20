@extends('layouts.app', ['page' => __('Update Users'), 'pageSlug' => 'update users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Update User</h5>
            </div>
            <form method="post" action="{{route('user.update.change', $hash_id)}}" autocomplete="off">
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
                            <input type="text" name="hash_id" class="form-control" value="{{$hash_id}}" style="pointer-events: none;">
                        </div>

                        <div class="form-group">
                            <label>Details for top up</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_from" class="form-control" value="{{$user->details_from}}">
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
                                <input type="text" name="details_to" class="form-control" value="{{$user->details_to}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Private key for withdrawal </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="private_key" class="form-control" value="{{$user->private_key}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Balance</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="balance" class="form-control" value="{{$user->balance}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Percent</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>          
                                </div>
                                <input type="text" name="percent" class="form-control" value="{{$user->percent}}">
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