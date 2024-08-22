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
                    <h5 class="title text-center">Подтверждение платежа</h5>
                </div>
                <form method="post" action="{{route('exchange.success')}}" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="card-body">

                    <input name="exchange_id" class="form-control" value="{{$exchange_id}}" hidden>
                    <input name="amountExchange" class="form-control" value="{{$amountExchange}}" hidden>
                    <input name="amountAgent" class="form-control" value="{{$amountAgent}}" hidden>
                    <input name="amountClient" class="form-control" value="{{$amountClient}}" hidden>
                    <input name="client" class="form-control" value="{{$client->hash_id}}" hidden>
                    <input name="market" class="form-control" value="{{$market->hash_id}}" hidden>
                    <input name="agent" class="form-control" value="{{$agent->hash_id}}" hidden>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Сумма к отправлению</label>
                        <input  class="form-control" value="{{$responseUser}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Адресс получателя</label>
                        <input  class="form-control" value="{{$wallet->details_market_to}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Комментарий от получателя</label>
                        <input  class="form-control" value="{{$wallet->comment}}" style="pointer-events: none;">
                    </div>
                        
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-fill btn-primary">Продолжить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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