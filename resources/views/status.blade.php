@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Subscription status for <strong>{{ $email }}</strong></div>

                <div class="panel-body">
                    <h2>Mailchimp</h2>

                    @if (count($mailchimp))
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
                    @else
                        <h4>No mailchimp subscriptions...</h4>
                    @endif

                    <h2>Hubspot</h2>
                    {{-- Hubspot is whack --}}
                    {{-- <div>Global Subscription: {{ $hubspot->subscribed ? 'Yes' : 'No' }}</div> --}}
                    {{ dump($hubspot->getData()) }}
                    {{--
                    @if (count($hubspot->subscriptionStatuses))
                        <h4>Individual subscription statuses:</h4>
                        <ul>
                            @foreach ($hubspot->subscriptionStatuses as $status)
                                <li>{{ dump($hubspot->getData()) }}</li>
                            @endforeach
                        </ul>
                    @endif
                    --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
