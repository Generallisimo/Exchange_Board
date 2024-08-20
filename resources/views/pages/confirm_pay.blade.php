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
                    <h5 class="title text-center">Status payment</h5>
                </div>
                <div class="status">
                    <h1 class="status-text text-center">Transaction await</h1>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const status = document.querySelector('.status-text');
            function checkStatus(exchange){
                fetch(`http://195.2.85.68/api/payment/${exchange}`)
                    .then(response=>response.json())
                    .then(data => {
                        if(data.status === 'success'){
                            status.innerText = 'Transaction successful';
                            // clearInterval(requestFetch);
                        }else if(data.status === 'archive'){
                            status.innerText = 'Transaction error, go to support';
                            // clearInterval(requestFetch);
                        }else if(data.status === 'await'){
                            status.innerText = 'Transaction await';
                            // clearInterval(requestFetch);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            
            const exchangeIdUser = '{{ $exchange_id_user }}';
            const requestFetch = setInterval(() => checkStatus(exchangeIdUser), 5000);
        })
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