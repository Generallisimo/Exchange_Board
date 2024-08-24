@extends('layouts.app', ['page' => __('Пополнение'), 'pageSlug' => 'top up'])

@section('content')

    <div class="row">
        <div class="col-md-6" style="margin: 100px auto;">
            <div class="card">
                <div class="card-header">
                    <h5 class="title text-center">Статус платежа</h5>
                </div>
                <div class="status">
                    <div class="form-group ml-5 mr-5">
                        <label>Кошелек для оплаты:</label>
                        <input type="text" name="wallet" class="form-control" placeholder="введите сумму для пополнения" value="{{$wallet}}" style="pointer-events: none;">
                    </div>

                    <div class="form-group ml-5 mr-5">
                        <label>Сумма для оплаты ожидатеся:</label>
                        <input type="text" name="wallet" class="form-control" placeholder="введите сумму для пополнения" value="{{$amount}} USDT" style="pointer-events: none;">
                    </div></br></br>

                    <h1 class="status-text text-center">Платеж обрабатывается</h1>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const status = document.querySelector('.status-text');
            function checkStatus(wallet, amount, hash_id){
                fetch(`http://localhost:8000/api/top_up/${wallet}/${amount}/${hash_id}`)
                    .then(response=>response.json())
                    .then(data => {
                        const transactionId = data.result[0].transaction_id;
                        if(transactionId){
                            status.innerText = 'Платеж успешно обработан';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            
            const wallet = '{{$wallet}}';
            const amount = '{{$amount}}';
            const hash_id = '{{$hash_id}}';
            const requestFetch = setInterval(() => checkStatus(wallet, amount, hash_id), 5000);
        })
    </script>

@endsection