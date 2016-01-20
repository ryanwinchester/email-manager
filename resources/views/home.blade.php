@extends('layouts.app')

@section('styles')
    <style>
        .loading {
            text-align: center;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Manage</div>

                <div class="email-panel panel-body">
                    <form id="email-form" action="{{ route('email') }}" method="POST">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            {{ csrf_field() }}
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Check</button>
                        </div>
                    </form>
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
                $('.email-panel').addClass('loading').html('<img src="/img/loading.gif">');
            });
        });
    </script>
@endsection
