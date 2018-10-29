<h1 class="page-title">{{ $user->username }}</h1>


<div class="profile-basics row">
    <div class="col-md-8">
        <table class="table horizontal">
            <tbody>
                <tr>
                    <th class="title">{!! trans('users::gender') !!}:</th>
                    <td>
                        @if ($user->gender == 0)
                            {!! HTML::fontIcon('genderless') !!} {{ trans('users::unknown') }}
                        @elseif ($user->gender == 1)
                            {!! HTML::fontIcon('venus') !!} {{ trans('users::female') }}
                        @elseif ($user->gender == 2)
                            {!! HTML::fontIcon('mars') !!} {{ trans('users::male') }}
                        @elseif ($user->gender == 3)
                            {!! HTML::fontIcon('genderless') !!} {{ trans('users::other') }}
                        @endif                        
                    </td>
                </tr>
				<tr>
				<th class="title">{!! trans('users::platform') !!}:</th>
				<td>
						@if ($user->platform == 0)
							 {{ trans('users::unknown') }}
						@elseif ($user->platform == 1)
							{{ trans('users::xbox_one') }}
						@elseif ($user->platform == 2)
							{{ trans('users::ps4') }}
						@elseif ($user->platform == 3)
							{{ trans('users::pc') }}
						@endif 
				</td>
				</tr>
				@if($user->steam_id)
				<tr>
					<th class="title">{!! trans('users::steam_id') !!}:</th>
					<td>
						@if (filter_var($user->steam_id, FILTER_VALIDATE_URL))
							<a href="{{ $user->steam_id }}" target="_blank">{{ trans('app.link') }}</a>
						@else
							<a href="http://steamcommunity.com/id/{{ $user->steam_id }}" target="_blank">{{ $user->steam_id }}</a>
						@endif
					</td>
				</tr>
				@endif
                <tr>
                    <th class="title">{!! trans('users::birthdate') !!}:</th>
                    <td>{{ $user->birthdate }}</td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::occupation') !!}:</th>
                    <td>{{ $user->occupation }}</td>
                </tr>
				<tr>
					<th class="title">{!! trans('users::localisation') !!}:</th>
					<td>
						@if ($user->country->icon)
							{!! HTML::image($user->country->uploadPath().$user->country->icon, $user->country->title) !!}
						@endif
						{{ $user->country->title }}
					</td>
				</tr>
            </tbody>
        </table>
    </div>
    <div class="details col-md-4">
        @if ($user->image)
            <img src="{!! $user->uploadPath().$user->image !!}" alt="{{ $user->username }}">
        @else
            <img src="{!! asset('img/default/no_user.png') !!}" alt="{{ $user->username }}">
        @endif
		
		@if (user())
			<hr>
            @if (user()->id == $user->id)
				<a class="btn btn-default form-control" href="{!! url('users/'.$user->id.'/edit') !!}" title="{!! trans('forums::show_user_posts') !!}">{!! HTML::fontIcon('pencil') !!} Edit your profile </a>
            @else
				<a class="btn btn-default form-control" href="{!! url('messages/create/'.$user->username) !!}" title="{!! trans('users::send_msg') !!}">{!! HTML::fontIcon('envelope') !!} Message</a>
                <a class="btn btn-default form-control" href="{!! url('friends/add/'.$user->id) !!}" title="{!! trans('users::add_friend') !!}" <?php if (user()->id == $user->id or user()->isFriendWith($user->id)) echo 'disabled="disabled"' ?>>{!! HTML::fontIcon('user-plus') !!} Add as Friend</a>
			@endif
		@endif
	</div>
	
	<div class="container-fluid">
		<div class="col-md-12">
			<h2> About {!! $user->username !!}</h2>
			<p>{!! $user->about !!}</p>
		</div>
	</div>
	@if(user())
		@if($won->count() > 0)
		<div class="container-fluid">
			<h2>Solo Cup Matches - Won: {!! $won->count() !!} </h2><br>
			@foreach ($won as $match)
				<div class="well text-center">
					<h3>{{ $match->created_at->dateTime() }} -{{ $match->cup->game->title }}</h3>
					<h4><a href="{{ url('cups/'.$match->cup->id.'/'.$match->cup->slug) }}">{{ $match->cup->title }}</a><br><br>
					<a class='btn form-control' href="{!! url('cups/matches/'.$match->id) !!}">View Match</a></h4>
				</div>
			@endforeach
		</div>
		@endif
	@endif
</div>

