<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email Subscription Manager</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/paper/bootstrap.min.css" rel="stylesheet" integrity="sha256-ZSKfhECi0yCEmGVAuQLWTHtJEn2vBNPexEWsJCIC/Nc= sha512-b+mSnD4QXw1uYwkgJ3d0XxoMXo+ZKHJNTNNFIddJ0IazcwKvKYtIlWADZ1JEREJzxUG428sfCw7qDuswAFcrOQ==" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Lato';
        }
        .fa-btn {
            margin-right: 6px;
        }
        input#email {
            width: 260px;
            background-color: #fff;
            padding: 3px;
        }
    </style>

    @yield('styles')

</head>
<body id="app-layout">

    @include('partials.nav')

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#email-form').submit(function(e){
                var btn = $(this).find('button[type=submit]');
                btn.button('loading');
            });

        });
    </script>

    @yield('scripts')

</body>
</html>
