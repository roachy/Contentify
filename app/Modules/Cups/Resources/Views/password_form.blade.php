<h1 class="page-title">{{ trans('app.join') }} {{$team->title}}</h1>

<div class="container">
	<div class='col-md-2'>
		<img class='img img-responsive' src="{{ $team->uploadPath().$team->image }}" />
	</div>
	
		
	<div class='col-md-5'>
		<b> Please enter the password which will have been provided to you by a Team Organizer </b><br />
		{!! Form::errors($errors) !!}
		
		{!! Form::open(['url' => 'cups/teams/join/'.$team->id]) !!}
			{!! Form::smartPassword() !!}

			{!! Form::actions(['submit'], false, ['class' => 'form-control']) !!}    
		{!! Form::close() !!}
	</div>
</div>