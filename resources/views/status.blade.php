@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit <strong>{{ $email }}</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <form action="{{ route('email.change', [$email]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label for="email" class="control-label">Change email to</label>
                                    <input type="email" name="new_email" id="new_email" placeholder="New email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning">Change</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4" style="text-align:center;">
                            <form action="{{ route('email.unsubscribe', [$email]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label>Unsubscribe this user from all lists</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg">UNSUBSCRIBE ALL</button>
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
                        <h2>{{ $service['name'] }}</h2>
                        <ul>
                            @foreach ($service['statuses'] as $status)
                                <li>
                                    @if ($status['subscribed'])
                                        <label class="label label-success">Yes</label>
                                    @else
                                        <label class="label label-danger">No</label>
                                    @endif
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
