@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Subscription status for <strong>{{ $email }}</strong></div>

                <div class="panel-body">
                    <form action="/status/{{ $email }}/unsubscribe" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit" class="btn btn-danger btn-lg">UNSUBSCRIBE ALL</button>
                    </form>
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
