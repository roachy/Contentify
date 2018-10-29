<h1 class="page-title">
    <a class="back" href="{!! url('cups/teams/overview') !!}" title="{{ trans('cups::my_teams') }}">{!! HTML::fontIcon('chevron-left') !!}</a>
    <em>{{ $team->title }}</em>
</h1>

@if( !user() )
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
	
	<div class="alert alert-info text-center">
		@widget('Auth::Login')
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
						 <input type="checkbox" data-user-id="{{ $member->id }}" {{ $member->pivot->organizer ? 'checked="1"' : null }}>
					@else
						{!! $member->pivot->organizer ? HTML::fontIcon('shield') . ' Captain' : HTML::fontIcon('user') . ' Member' !!}
					@endif
					<br/><br/>
					@if (user() and ($organizer or user()->isSuperAdmin()))
						<a class="btn btn-delete" href="{{ url('cups/teams/leave/'.$team->id.'/'.$member->id) }}">{{ trans('app.remove') }}</a>
					@endif
				</div>
			@endforeach
			</div>
	@endif
@else
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

	@if ($team->organizer or user()->isSuperAdmin())
		<a class="btn btn-default" href="{{ url('cups/teams/edit/'.$team->id) }}">{{ trans('app.edit') }}</a>
		<a class="btn btn-default" href="{{ url('cups/teams/delete/'.$team->id) }}">{{ trans('app.delete') }}</a>
	@endif
</div>
<hr>

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
					{!! $member->pivot->organizer ? HTML::fontIcon('check') : HTML::fontIcon('close') !!}
				@endif
				<br/><br/>
				@if (user() and ($organizer or user()->isSuperAdmin()))
					<a class="btn btn-default" href="{{ url('cups/teams/leave/'.$team->id.'/'.$member->id) }}">{{ trans('app.remove') }}</a>
                @endif
			</div>
        @endforeach
		</div>
@endif


@if ($team->hidden)
    {{ trans('cups::team_deleted') }}
@else
    @if (user())
		@if(! $team->isMember(user()))
			<hr>
			<a class="btn btn-default form-control" href="{{ url('cups/teams/join/'. $team->id ) }}">Join {{ $team->title }}</a>
		@endif
	@else
			<h3 class="text-center"> Want to manage your own team? Register an account or login </h3>
			<a class="btn btn-default form-control" href="{{ url('register') }}"> Register </a>
			<a class="btn btn-default form-control" href="{{ url('auth/login') }}"> Login </a>
	@endif
@endif


@if (sizeof($team->cups) > 0)
     <h2>Cups Entered</h2>
	<div class="container">
		@foreach ($team->cups as $cup)
			<div class='col-md-4'>
				<a href="{{ url('cups/'.$cup->id.'/'.$cup->slug) }}">
					<div class="text-center">
						@if ($cup->image)
							<div class="image text-center">
								<img src="{{ $cup->uploadPath().$cup->image }}" alt="{{ $cup->title }}">
							</div>
						@endif
						<h4>{{ $cup->title }}</h4>
						{!! HTML::fontIcon('users') !!} {{ $cup->players_per_team }}on{{ $cup->players_per_team }}<br />
						{!! HTML::fontIcon('crosshair') !!} {{ $cup->game->short }}<br />
						{!! HTML::fontIcon('calendar') !!} {{ $cup->start_at }}<br />
					</div>
				</a>
			</div>
		@endforeach
	</div>
@endif

@endif

<script>
    $(document).ready(function()
    {
        $('.page table input').change(function()
        {
            var userId = $(this).attr('data-user-id');

            $.ajax({
                url: contentify.baseUrl + 'cups/teams/organizer/{{ $team->id }}/' + userId,
                type: 'POST',
                data: {
                    organizer: this.checked ? 1 : 0
                }
            }).fail(function(response)
            {
                contentify.alertError(response.responseText);
            });
        });
    });
</script>