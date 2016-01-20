@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form action="/status" method="POST">
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
