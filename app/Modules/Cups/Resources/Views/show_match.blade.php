<h1 class="page-title">
    <a class="back" href="{!! url('cups/'.$match->cup->id.'/'.$match->cup->slug) !!}" title="{{ trans('app.back') }}">{!! HTML::fontIcon('chevron-left') !!}</a>
    {{ trans('app.object_match') }}
</h1>

@if ($match->left_participant && $match->right_participant)
	<div class="overview clearfix">
		<div class="left">
			@include('cups::participant', ['cup' => $match->cup, 'participant' => $match->left_participant, 'images' => true])
			
			@if($match->left_score > $match->right_score)
				<h3> Winner! </h3>
			@endif
		</div>
		<div class="mid">
		@if($match->cup->game->title == "Battlefield 1")
			<h4> Game Tickets </h4>
			{{ $match->left_score }} : {{ $match->right_score }}
		@else
			<h4> Score </h4>
			{{ $match->left_score }} : {{ $match->right_score }}
		@endif
		</div>
		<div class="right">
			@include('cups::participant', ['cup' => $match->cup, 'participant' => $match->right_participant, 'images' => true])
		</div>
	</div>
@endif

<div class="details">
    <table class="table horizontal">
        <tbody>
            @if ($canConfirmLeft or $canConfirmRight)
                <tr>
                    <th>{!! trans('cups::confirm_score') !!}</th>
                    <td>
                        @if ($canConfirmLeft) 
                            {!! Form::open(['url' => 'cups/matches/confirm-left/'.$match->id, 'class' => 'form-inline']) !!}
                                <input type="text" class="form-control" name="left_score" value="{{ $match->left_score }}"> : <input type="text" class="form-control" name="right_score" value="{{ $match->right_score }}"> <button class="btn submit">{{ $match->with_teams ? $match->left_participant->title : $match->left_participant->username }}:  {!! trans('cups::confirm_score') !!}</button>
                            {!! Form::close() !!}
                        @endif
                        @if ($canConfirmRight)
                            {!! Form::open(['url' => 'cups/matches/confirm-right/'.$match->id, 'class' => 'form-inline']) !!}
                                <input type="text" class="form-control" name="left_score" value="{{ $match->left_score }}"> : <input type="text" class="form-control" name="right_score" value="{{ $match->right_score }}"> <button class="btn submit">{{ $match->with_teams ? $match->right_participant->title : $match->right_participant->username }}: {!! trans('cups::confirm_score') !!}</button>
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endif
            <tr>
                <th>{!! trans('app.object_cup') !!}</th>
                <td>
                    <a href="{{ url('cups/'.$match->cup->id.'/'.$match->cup->slug) }}">{{ $match->cup->title }}</a>
                </td>
            </tr>
            <tr>
                <th>{!! trans('app.object_game') !!}</th>
                <td>{{ $match->cup->game->title }}</td>
            </tr>
            <tr>
                <th>{!! trans('app.date') !!}</th>
                <td>{{ $match->created_at->dateTime() }}</td>
            </tr>
            <tr>
                <th>{!! trans('app.closed') !!}</th>
                <td>{!! $match->winner_id ? HTML::fontIcon('check') : HTML::fontIcon('close') !!}</td>
            </tr>
            @if ($match->next_match_id)
                <tr>
                    <th>{!! trans('cups::next_match') !!}</th>
                    <td>
                        <a href="{{ url('cups/matches/'.$match->next_match_id) }}">{{ trans('app.link') }}</a>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<hr>
<b class="text-center"> Please make sure that your dispute is well detailed before submitting. </b>
<a href="{{ url('contact') }}" class='btn btn-delete form-control'> Dispute Match </a>

{!! Comments::show('cups_matches', $match->id) !!}