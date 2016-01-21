@extends('layouts.app')

@section('styles')
    <style>
        .loading {
            text-align: center;
        }
        img {
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="email-panel panel-body">
                    <p>You are logged in!</p>
                    <p>To update an email, enter it in the search field above!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('#email-form').submit(function(e) {
                e.target.submit();
                var max = 11;
                var num = Math.floor((Math.random() * max) + 1); // random number between 1 and max
                $('.email-panel').addClass('loading').html(
                    '<img src="/img/loaders/loader'+num+'.gif">'
                );
            });
        });
    </script>
@endsection
