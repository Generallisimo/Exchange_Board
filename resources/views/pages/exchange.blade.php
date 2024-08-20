<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Exchange</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('black') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('black') }}/img/favicon.png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('black') }}/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS -->
    <link href="{{ asset('black') }}/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="{{ asset('black') }}/css/theme.css" rel="stylesheet" />
</head>

<body class="{{ $class ?? '' }}">
    <div class="row">
        <div class="col-md-6" style="margin: 100px auto;">
            <div class="card">
                <div class="card-header">
                    <h5 class="title text-center" style="font-size: 30px;">Payment</h5>
                </div>
                <form method="post" action="{{route('exchange.confirm', ['client'=>$client_id, 'market'=>$market_id, 'amount'=>$amount, 'exchange_id'=>$exchange_id])}}" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <input name="exchange_id" class="form-control" value="{{$exchange_id}}" hidden>
                            <input name="amount" class="form-control" value="{{$amount}}" hidden>
                            <input name="client_id" class="form-control" value="{{$client_id}}" hidden>
                            <input name="market_id" class="form-control" value="{{$market_id}}" hidden>
                        </div>
                    


                        <div class="form-group text-center" style="display: grid;">
                            <label for="currency">Select Currency</label>
                            <div id="currency-options" class="btn-group" role="group" style="margin: 0 auto;">
                                    <button type="button" class="btn btn-outline-primary currency-btn" data-currency="RUB">
                                        RUB
                                    </button>
                                    <button type="button" class="btn btn-outline-primary currency-btn" data-currency="UAH">
                                        UAH
                                    </button>
                            </div>
                        </div>

                        <div class="form-group text-center" style="display: grid;">
                            <label for="method">Select Method</label>
                            <div id="method-options" class="btn-group" role="group" style="margin: 0 auto;">
                                @foreach($methods as $method)
                                    <button type="button" class="btn btn-outline-secondary method-btn" data-method="{{ $method->name_method }}" data-currency="{{ $method->currency }}" style="display: none;">
                                        {{ $method->name_method }}
                                    </button>
                                @endforeach
                            </div>
                            <!-- Скрытое поле для отправки выбранного метода -->
                            <input type="hidden" name="method" id="selected_method">
                        </div>

                        
                        <div class="card-footer text-center" >
                            <button type="submit" class="btn btn-fill btn-primary">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currencyButtons = document.querySelectorAll('.currency-btn');
        const methodButtons = document.querySelectorAll('.method-btn');
        const selectedMethodInput = document.getElementById('selected_method');

        // Обработчик выбора валюты
        currencyButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Удаляем класс "active" у всех кнопок валют
                currencyButtons.forEach(btn => btn.classList.remove('active'));
                // Добавляем класс "active" к нажатой кнопке
                this.classList.add('active');

                // Получаем выбранную валюту
                const selectedCurrency = this.getAttribute('data-currency');

                // Фильтруем и отображаем методы, соответствующие выбранной валюте
                methodButtons.forEach(methodButton => {
                    if (methodButton.getAttribute('data-currency') === selectedCurrency) {
                        methodButton.style.display = 'inline-block';
                    } else {
                        methodButton.style.display = 'none';
                    }
                    methodButton.classList.remove('active');
                });

                // Очистить выбранный метод при изменении валюты
                selectedMethodInput.value = '';
            });
        });

        // Обработчик выбора метода
        methodButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Удаляем класс "active" у всех кнопок методов
                methodButtons.forEach(btn => btn.classList.remove('active'));
                // Добавляем класс "active" к нажатой кнопке
                this.classList.add('active');
                // Устанавливаем значение в скрытое поле input
                selectedMethodInput.value = this.getAttribute('data-method');
            });
        });
    });
</script>



    <script src="{{ asset('black') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('black') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('black') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('black') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <!-- Place this tag in your head or just before your close body tag. -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
    <!-- Chart JS -->
    {{-- <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script> --}}
    <!--  Notifications Plugin    -->
    <script src="{{ asset('black') }}/js/plugins/bootstrap-notify.js"></script>

    <script src="{{ asset('black') }}/js/black-dashboard.min.js?v=1.0.0"></script>
    <script src="{{ asset('black') }}/js/theme.js"></script>
</body>

</html>