@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .subscription-statuses li {
            padding-bottom: 3px;
        }
        .subscription-statuses label {
            margin-right: 8px;
        }
        a.panel-heading {
            display: block;
        }
    </style>
@endsection

@section('search-bar')

@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('warning'))
                <div class="alert alert-warning">
                    <p>{!! Session::get('warning') !!}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-warning">
                        <a class="panel-heading" data-toggle="collapse" href="#collapse-email-change">
                            Change email <span class="caret"></span>
                        </a>
                        <div class="panel-body collapse" id="collapse-email-change">
                            @include('partials.email-change')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-warning">
                        <a class="panel-heading" data-toggle="collapse" href="#collapse-name-change">
                            Change name <span class="caret"></span>
                        </a>
                        <div class="panel-body collapse" id="collapse-name-change">
                            @include('partials.name-change')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-warning">
                        <a class="panel-heading" data-toggle="collapse" href="#collapse-unsubscribe">
                            Unsubscribe <span class="caret"></span>
                        </a>
                        <div class="panel-body collapse" id="collapse-unsubscribe">
                            @include('partials.email-unsubscribe')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Subscription status</div>

                <div class="panel-body">
                    @foreach ($services as $service)
                        @include('partials.subscription-status')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {

            // $('#collapse-email-change, #collapse-name-change, #collapse-unsubscribe').hide();

            $('#change-email-form').submit(function (e) {
                e.preventDefault();
                var $this = $(this);
                var $button = $this.find('button[type=submit]');
                disableButton($button);
                swal({
                    title: "Ground Control to Major Tom!",
                    text: "Do you really want to change <b>{{ $email }}</b> to <b>" + $this.find('#new_email').val() + "</b>?",
                    type: "warning",
                    html: true,
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "Nevermind.",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(confirmed) {
                    if (confirmed) {
                        e.target.submit();
                        setTimeout(function(){
                            // wait 20 seconds
                        }, 20000);
                    } else {
                        enableButton($button);
                    }
                });
            });

            $('#unsubscribe-form').submit(function (e) {
                e.preventDefault();
                var $this = $(this);
                var $button = $this.find('button[type=submit]');
                disableButton($button);
                swal({
                    title: "Are you sure?",
                    text: "Do you really want to permanently <em>unsubscribe</em> <b>{{ $email }}</b>? This can't be undone.",
                    type: "warning",
                    html: true,
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Just do it!",
                    cancelButtonText: "Forget it...",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(confirmed) {
                    if (confirmed) {
                        e.target.submit();
                        setTimeout(function(){
                            // wait 20 seconds
                        }, 20000);
                    } else {
                        enableButton($button);
                    }
                });
            });

            function disableButton(btn) {
                btn.button('loading');
            }

            function enableButton(btn) {
                btn.button('reset');
            }

        });
    </script>
@endsection
