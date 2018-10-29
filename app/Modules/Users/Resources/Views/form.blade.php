<h1 class="page-title">{{ trans('app.profile') }}</h1>

{!! Form::errors($errors) !!}

@if (isset($user))
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'files' => true, 'method' => 'PUT']) !!}
@else
    {!! Form::open(['url' => 'users']) !!}
@endif
	{!! Form::smartImageFile('image', trans('users::image')) !!}

    {!! Form::smartText('username', trans('app.username')) !!}

    {!! Form::smartEmail('email', trans('app.email')) !!}

    {!! Form::smartGroupOpen(null, trans('app.password')) !!}
        {!! button(trans('users::change'), url('users/'.$user->id.'/password')) !!}
    {!! Form::smartGroupClose() !!}
	
	{!! Form::smartGroupOpen('platform', trans('users::platform')) !!}
        {!! Form::select('platform', array('0' => 'None', '1' => trans('users::xbox_one'), '2' => trans('users::ps4'), '3' => trans('users::pc'))) !!}
    {!! Form::smartGroupClose() !!}

    {!! Form::smartSelectForeign('language_id', trans('users::localisation')) !!}

    {!! Form::helpBlock(trans('users::local_info')) !!}
	
	{!! Form::smartTextarea('about', trans('users::about')) !!}
   
	{!! Form::smartGroupOpen('gender', trans('users::gender')) !!}
        {!! Form::select('gender', array('0' => trans('users::unknown'), '1' => trans('users::female'), '2' => trans('users::male'), '3' => trans('users::other'))) !!}
    {!! Form::smartGroupClose() !!}
	
    {!! Form::smartSelectForeign('country_id', trans('app.object_country')) !!}    

    {!! Form::smartText('birthdate', trans('users::birthdate')) !!}

    {!! Form::smartText('occupation', trans('users::occupation')) !!}

	{!! Form::smartImageFile('avatar', trans('users::avatar')) !!}
	
    {!! Form::smartText('signature', trans('users::signature')) !!}

    {!! Form::actions(['submit' => trans('app.update')]) !!}
{!! Form::close() !!}