@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Mailchimp</h2>

                    <ul>
                        @foreach($mailchimp as $subscription)
                            <li>
                                {{ $subscription['name'] }}
                                @if (count($subscription['groupings']))
                                    <ul>
                                        @foreach ($subscription['groupings'] as $grouping)
                                            <li>{{ $grouping }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <h2>Hubspot</h2>

                    <div>Subscribed: {{ $hubspot->subscribed ? 'Yes' : 'No' }}</div>
                    
                    @if (count($hubspot->subscriptionStatuses))
                        <h4>Individual subscription statuses:</h4>
                        <ul>
                            @foreach ($hubspot->subscriptionStatuses as $status)
                                <li>{{ dump($hubspot) }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
