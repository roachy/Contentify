<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Running with Contentify CMS -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Contentify">
    <meta name="base-url" content="{!! url('/') !!}">
    <meta name="asset-url" content="{!! asset('') !!}">
    <meta name="csrf-token" content="{!! Session::get('_token') !!}">
    <meta name="locale" content="{!! Config::get('app.locale') !!}">
    <meta name="date-format" content="{!! trans('app.date_format') !!}">
    {!! HTML::metaTags($metaTags) !!}

    @if ($title)
        {!! HTML::title($title) !!}
    @else
        {!! HTML::title(trans_object($controllerName, $moduleName)) !!}
    @endif

    <link rel="icon" type="image/png" href="{!! asset('img/favicon_180.png') !!}"><!-- Big icon -->
    <link rel="shortcut icon" type="picture/x-icon" href="{!! asset('img/default/favicon.png') !!}">

    {!! HTML::style('vendor/font-awesome/css/font-awesome.min.css') !!}
    {!! HTML::style('css/backend.css') !!}
    {!! HTML::style('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.css') !!}
    {!! HTML::style('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') !!}
    
    {!! HTML::jsTranslations() !!}
    <!--[if lt IE 9]>
        {!! HTML::script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') !!}
        {!! HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
    <![endif]-->
    {!! HTML::script('vendor/jquery/jquery-1.12.4.min.js') !!}
    {!! HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js') !!}
    {!! HTML::script('vendor/moment/moment.js') !!}
    {!! HTML::script('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js') !!}
    {!! HTML::script('vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') !!}
    {!! HTML::script('vendor/ckeditor/ckeditor.js') !!}
    {!! HTML::script('vendor/contentify/contentify.js') !!}
    {!! HTML::script('vendor/contentify/backend.js') !!}
	
	<style type="text/css">
		#sidebar .account { margin: 100px 0 40px 0; }
		.header-bar{ background:RGBA(0,0,0,0.65); }
	</style>
</head>
<body>
    <div id="page-container">
        <noscript>
            {!! HTML::fontIcon('exclamation-circle') !!} {!! trans('app.no_js') !!}
        </noscript>

        <header id="header">
            <div class="header-bar container-fluid">
                <a class="header-logo" href="{!! route('admin.dashboard') !!}" title="{!! trans('app.admin_dashboard') !!}">
    
                </a>
                <div class="header-navigation">
                    @if ($contactMessages)
                    <span class="msg">{!! HTML::fontIcon('envelope') !!} {!! $contactMessages !!}</span>
                    @endif

                    <nav>
                        <ul class="list-inline">
                            <li><a href="http://github.com/Contentify/Contentify/wiki" title="Help" target="_blank">{!! HTML::fontIcon('question-circle') !!} <span class="text">{{ trans('app.help') }}</span></a></li>
                            <li><a href="{!! route('home') !!}" title="Website">{!! HTML::fontIcon('eye') !!} <span class="text">{{ trans('app.website') }}</span></a></li>
                            <li><a href="{!! route('logout') !!}" title="Logout">{!! HTML::fontIcon('sign-out') !!} <span class="text">{{ trans('app.logout') }}</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <aside id="sidebar">
            <a class="hamburger" href="#">{!! HTML::fontIcon('navicon') !!}</a>
            <div class="account">
                <a id="profile-link" href="{!! url('users/'.user()->id.'/'.user()->slug) !!}">
                    <div class="avatar">
                        @if (user()->image)
                            <div class="image" style="background-image: url('{!! asset('uploads/users/80/'.user()->image) !!}')"></div>
                        @endif
                        <div class="welcome">{{ trans('app.welcome') }}, <span>{!! user()->username !!}</span></div>
                    </div>
                </a>                
            </div>
            
            {!! HTML::renderBackendNav() !!}
        </aside>

        <section id="content" class="clearfix">
            @if (Session::get('_alert'))
                @include('alert', ['type' => 'info', 'title' => Session::get('_alert')])
            @endif

            <!-- Render JavaScript alerts here -->
            <div class="alert-area"></div>

            @if (isset($page))
                <a class="page-head" href="{!! url('admin/'.strtolower($controllerName)) !!}">
                    {!! HTML::fontIcon($controllerIcon) !!}
                    {!! trans_object($moduleName, $moduleName) !!}
                    @if ($controllerName != $moduleName)
                        \ {!! trans_object($controllerName, $moduleName) !!}
                    @endif
                </a>

                <div class="page page-{!! strtolower($controllerName) !!} {!! $templateClass !!}">
                    {!! $page !!}
                </div>
            @endif
        </section>

        <footer id="footer">
            <span class="version">Version {!! Config::get('app.version') !!}</span>
            <a class="top" href="#">{!! trans('app.top') !!}</a>
        </footer>
    </div>
</body>
</html>