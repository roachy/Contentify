<style type="text/css">
	.well { background:#000; }
	.widget .widget-team-control{ padding:15px; }
	.btn-edit:hover { background:orange; }
	.btn-delete:hover { background:red; }
</style>

<br>
<div class="widget widget-team-control">
	<ul class="list-unstyled">
		@foreach ($teams as $team)
			<li class="clearfix">
				<a href="{{ url('cups/teams/'.$team->id.'/'.$team->slug) }}">
					@if ($team->image)
                        <img height=80px width=80px src="{{ $team->uploadPath().$team->image }}" alt="{{ $team->title }}">
                    @else
                        <span class="title">{{ $team->title }}</span>
                    @endif
				</a>
				@if (user())
					<div class="well actions pull-right">
						@if ($team->organizer)
							<a class="btn btn-edit" href="{{ url('cups/teams/edit/'.$team->id) }}">{{ trans('app.edit') }}</a>
							<a class="btn btn-delete" href="{{ url('cups/teams/delete/'.$team->id) }}">{{ trans('app.delete') }}</a>
						@endif

					</div>
				@endif
			</li>
		@endforeach
	</ul>
</div>