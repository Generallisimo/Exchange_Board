@extends('layouts.app', ['page' => __('Добавить реквезиты'), 'pageSlug' => 'add details'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Добавить новые реквезиты обменникам</h5>
            </div>
            <form method="post" action="{{route('create.new.wallets')}}" autocomplete="off">
                @csrf
                <div class="card-body">
                    

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор обменника</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="hash_id">        
                            @foreach($markets as $market)
                                <option value="{{$market->hash_id}}">{{$market->hash_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор метода оплаты</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="name_method">        
                            @foreach($methods as $method)
                                <option value="{{$method->name_method}}">{{$method->name_method}} {{$method->currency}}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label>Реквезиты пополнения</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="details_market_to" class="form-control" placeholder="введите реквезиты пополнения">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Комментарий обменника для перевода</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="comment" class="form-control" placeholder="введите комментарий">
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection