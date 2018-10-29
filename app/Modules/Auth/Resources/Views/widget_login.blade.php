<div class="widget widget-auth-login">
	<h3> Join the community to access more information about this team or to create your own! </h3>
    <a class="btn btn-default" href="{{ url('auth/login') }}">{!! HTML::fontIcon('unlock-alt') !!} {{ trans('auth::login') }}</a>
    <a class="btn btn-default" href="{{ url('auth/registration/create') }}">{!! HTML::fontIcon('plus') !!} {{ trans('auth::register') }} a new account</a>
    <a class="btn btn-default" href="{{ url('auth/steam') }}" title="STEAM {{ trans('auth::login') }}">{!! HTML::fontIcon('steam') !!} Register with Steam</a>
</div>