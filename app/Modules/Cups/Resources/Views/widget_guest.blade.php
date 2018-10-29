<div class="alert text-center">
		@widget('Auth::Login')
	</div>
	<div class="image text-center">
	<h3>[{{$team->platoon_tag}}]</h3>
	@if ($team->image)
			<img class="img" src="{{ $team->uploadPath().$team->image }}" alt="{{ $team->title }}">
	@endif
	<h2>
	@if ($team->platform == 0)
		 {{ trans('users::unknown') }}
	@elseif ($team->platform == 1)
		{{ trans('users::xbox_one') }}
	@elseif ($team->platform == 2)
		{{ trans('users::ps4') }}
	@elseif ($team->platform == 3)
		{{ trans('users::pc') }}
	@endif 
	</h2>
</div>

@if (sizeof($team->members) > 0)
	<h3>{{ trans('app.object_members') }}</h3>
		<div class='row'>
		@foreach ($team->members as $member)
			<div class='col-md-3 text-center'>
				<a href="{{ url('users/'.$member->id.'/'.$member->slug) }}">
					{{ $member->username }}
					@if ($member->image)
						<img height=110px width=120px class='img' src="{!! $member->uploadPath().$member->image !!}" alt="{{ $member->username }}">
					@else
						<img height=110px width=120px class='img' src="{!! asset('img/default/no_user.png') !!}" alt="{{ $member->username }}">
					@endif
				</a>
				<hr/>
				@if (user() and ($organizer or user()->isSuperAdmin()))
					Organizer <input type="checkbox" data-user-id="{{ $member->id }}" {{ $member->pivot->organizer ? 'checked="1"' : null }}>
				@else
					Organizer {!! $member->pivot->organizer ? HTML::fontIcon('check') : HTML::fontIcon('close') !!}
				@endif
				<br/><br/>
				@if (user() and ($organizer or user()->isSuperAdmin()))
					<a class="btn btn-default" href="{{ url('cups/teams/leave/'.$team->id.'/'.$member->id) }}">{{ trans('app.remove') }}</a>
				@endif
			</div>
		@endforeach
		</div>
@endif