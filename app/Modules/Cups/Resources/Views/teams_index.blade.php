<h1 class="page-title">All Registered Teams &nbsp;| 
	<a class='btn' href="{{ url('cups/teams/create') }}">{!! HTML::fontIcon('plus') !!} Create a New Team </a>
	@if( $user )
		| <a class='btn' href="{{ url('cups/teams/overview/'.$user->id) }}">{!! HTML::fontIcon('users') !!} Your Teams </a>
	@endif
</h1> 

<div class='container-fluid'>
	@foreach ($teams as $team)
		@if( !$team->hidden  )
			<div class='col-md-6 text-center'>
				<a href="{{ url('cups/teams/'.$team->id.'/'.$team->slug) }}">
					<h2>{{ $team->title }}</h2>
					@if ($team->image)
						<div class="image">
							<img height=160px width=160px class='img img-circle' src="{{ $team->uploadPath().$team->image }}" alt="{{ $team->title }}">
						</div>
					@else
						<div class="image">
							<img height=160px width=160px src="http://via.placeholder.com/200/000000"/>
						</div>
					@endif
					<br />
						<a class="form-control btn btn-default" href="{{ url('cups/teams/'.$team->id) }}">View</a>
					@if(user())
						<hr>
						<div class="actions">
							@if ($team->organizer or $user->isSuperAdmin())
								<a class="form-control btn btn-edit" href="{{ url('cups/teams/edit/'.$team->id) }}">{{ trans('app.edit') }}</a>
								<a class="form-control btn btn-delete" href="{{ url('cups/teams/delete/'.$team->id) }}">{{ trans('app.delete') }}</a>
							@endif
						</div>
					@endif
				</a>
			</div>
		@endif
	@endforeach
</div>
</br>

<div class="text-center">
	{{ $teams->render() }}
</div>