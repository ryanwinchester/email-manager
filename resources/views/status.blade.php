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
    </style>
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
            <div class="panel panel-default">
                <div class="panel-heading">Edit <strong>{{ $email }}</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <form id="change-email-form" action="{{ route('email.change', [$email]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label for="email" class="control-label">Change email to</label>
                                    <input type="email" name="new_email" id="new_email" placeholder="New email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning" data-loading-text="Loading..." autocomplete="off">Change</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4" style="text-align:center;">
                            <form id="unsubscribe-form" action="{{ route('email.unsubscribe', [$email]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label>Unsubscribe this user from all lists</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg" data-loading-text="Loading..." autocomplete="off">UNSUBSCRIBE ALL</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Subscription status for <strong>{{ $email }}</strong></div>

                <div class="panel-body">
                    @foreach ($services as $service)
                        <h2>{{ $service['name'] }} Lists</h2>
                        <ul class="subscription-statuses list-unstyled">
                            @foreach ($service['statuses'] as $status)
                                <li>
                                    <label class="label label-{{$status['subscribed'] ? 'success' : 'danger' }}">
                                        &nbsp;
                                    </label>
                                    {{ $status['name'] }}
                                    @if (isset($status['groupings']))
                                        <ul>
                                            @foreach ($status['groupings'] as $grouping)
                                                <li>
                                                    @if ($status['subscribed'])
                                                        <label class="label label-success">Yes</label>
                                                    @else
                                                        <label class="label label-danger">No</label>
                                                    @endif
                                                    {{ $grouping['name'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
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
