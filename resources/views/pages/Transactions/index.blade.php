@extends('layouts.app', ['page' => __('Транзакции'), 'pageSlug' => 'market board'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if(session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            @if($errors->has('transactions_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('transactions_error') }}
                </div>
            @endif
            <div class="card-header">
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="await_but" type="button" class="btn btn-default">Ожидание</button>
                    <button id="dispute_but" type="button" class="btn btn-default">Диспуты</button>
                    <button id="success_but" type="button" class="btn btn-default">Успешные</button>
                    <button id="archive_but" type="button" class="btn btn-default">Архивированные</button>
                    <button id="error_but" type="button" class="btn btn-default">Ошибка</button>
                </div>
            </div>
            <div class="table-responsive">
            
                <!-- for all view -->
                
                @include('pages.transactions.status.dispute', ['exchangesDispute'=>$data['exchangesDispute']])
                @include('pages.transactions.status.archive', ['exchangesArchive'=>$data['exchangesArchive']])
                @include('pages.transactions.status.success', ['exchangesSuccess'=>$data['exchangesSuccess']])
                @include('pages.transactions.status.await', ['exchanges'=>$data['exchanges']])
                @include('pages.transactions.status.error', ['exchangesError'=>$data['exchangesError']])
           
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js') }}/transactions/SelectTransactionsIndex.js"></script>
@endsection