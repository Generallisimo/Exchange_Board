@extends('layouts.payments.app')


@section('content')
<div class="row">
    <div class="col-md-6" style="margin: 100px auto;">
        <div class="card">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
            <div class="card-header">
                <h5 class="title text-center" style="font-size: 30px;">Оплата</h5>
            </div>
            <form 
                method="get" 
                action="{{route(
                    'payment.create', 
                    [
                        'client'=>$data['client_id'], 
                        'amount'=>$data['amount'], 
                        'currency'=>$data['currency'],
                        'market'=>$data['market_id'],
                        'exchange_id'=>$data['exchange_id']
                    ]
                )}}" 
                autocomplete="off">
                @csrf
                <div class="card-body">

                    <div class="form-group text-center" style="display: grid;">
                        <label for="method">Выбор метода</label>
                        <div id="method-options" class="btn-group" role="group" style="margin: 0 auto;">
                            @foreach($data['unique_method'] as $name)
                            <input type="button" class="btn btn-outline-secondary method-btn" value="{{ $name->name_method }}" onclick="setMethod('{{ $name->name_method }}')">
                            @endforeach
                        </div>
                        <input type="hidden" name="method" id="method">
                    </div>

                    @error('method')
                        <div class="text-danger">Выберите метод оплаты!</div>
                    @enderror



                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-fill btn-primary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('js') }}/exchanges/SelectMethodIndex.js"></script>
@endsection