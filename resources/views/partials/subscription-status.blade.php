
<h2>{{ $service['name'] }} Lists</h2>
<ul class="subscription-statuses list-unstyled">
    @foreach ($service['statuses'] as $status)
        <li>
            @if ($status['subscribed'] === 1)
                <label class="label label-success">&nbsp;</label>
            @elseif ($status['subscribed'] === -1)
                <label class="label label-danger">&nbsp;</label>
            @else
                <label class="label label-default">&nbsp;</label>
            @endif
            {{ $status['name'] }}
            @if (isset($status['groupings']))
                <ul class="list-unstyled" style="padding-left:26px;">
                    @foreach ($status['groupings'] as $grouping)
                        <li>
                            <label class="label label-{{ $status['subscribed'] ? 'success' : 'danger' }}">
                                &nbsp;
                            </label>
                            {{ $grouping['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
