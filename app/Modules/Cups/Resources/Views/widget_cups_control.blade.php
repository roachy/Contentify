<div class="widget widget-cup-control">
    @if ($cups and sizeof($cups) > 0)
        <ul class="list-unstyled">
            @foreach ($cups as $cup)
                <li>
                    <h4 class='text-center'><a href="{{ url('cups/'.$cup->id.'/'.$cup->slug) }}" title="{{ $cup->title }}">{{ $cup->title }}</a></h4>
                    
                    <p class="infos text-center">
                        {!! HTML::fontIcon('crosshairs') !!} {{ $cup->players_per_team.'on'.$cup->players_per_team }} {{ trans('app.mode') }}, {!! HTML::fontIcon('calendar') !!} {{ $cup->start_at }}, {!! HTML::fontIcon('clock-o') !!} {{ $cup->start_at->format('H:i') }}
                    </p>
                </li>
            @endforeach
        </ul>
    @else
		<br>
        {{ trans('cups::in_no_cups') }} <a href="{{ url('cups') }}">{{ trans('cups::join_a_cup') }}</a>
    @endif

    @if (user())
        <hr>
 
    @endif
</div>