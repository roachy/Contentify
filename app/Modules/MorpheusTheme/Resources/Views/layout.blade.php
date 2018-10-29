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
    @if ($openGraph)
        {!! HTML::openGraphTags($openGraph) !!}
    @endif

    @if ($title)
        {!! HTML::title($title) !!}
    @else
        {!! HTML::title(trans_object($controllerName, $moduleName)) !!}
    @endif

    <link rel="icon" type="image/png" href="{!! asset('img/favicon_180.png') !!}"><!-- Opera Speed Dial Icon -->
    <link rel="shortcut icon" type="picture/x-icon" href="{!! asset('favicon.png') !!}">
    <link rel="alternate" type="application/rss+xml" title="RSS News" href="{!! asset('rss/news.xml') !!}">

    {!! HTML::style('vendor/font-awesome/css/font-awesome.min.css') !!}
    {!! HTML::style(HTML::versionedAssetPath('css/frontend.css')) !!}

    {!! HTML::jsTranslations() !!}
    <!--[if lt IE 9]>
        {!! HTML::script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') !!}
        {!! HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
    <![endif]-->
    {!! HTML::script('vendor/jquery/jquery-1.12.4.min.js') !!}
    {!! HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js') !!}
    {!! HTML::script('vendor/contentify/contentify.js') !!}
    {!! HTML::script('vendor/contentify/frontend.js') !!}    
</head>
<body>
    @if(Config::get('app.theme_christmas'))
        @include('snow')
    @endif
    <header id="header">
        <div class="container">
            <div class="top-bar row">
                <a class="header-logo" href="{!! route('home') !!}">
                    {!! HTML::image(asset('img/header_logo.png', array('height' => 100) )) !!}
                </a>
                <div class="right">
                    @widget('Auth::Login')
                </div>
            </div>
        </div>
        <nav>
            <div class="container">
                <ul>
                    <li class="icon">{!! HTML::fontIcon('bars') !!}</li>
                    <li>{!! link_to('/', trans('app.home'), ['class' => 'active']) !!}</li>
                    <li>{!! link_to('cups', trans('app.object_cups')) !!}</li>
                    <li>{!! link_to('cups/teams/overview', trans('app.object_teams')) !!}</li>
                    <li>{!! link_to('streams', trans('app.object_streams')) !!}</li>
                    <li>{!! link_to('videos', trans('app.object_videos')) !!}</li>
                    <li>{!! link_to('forums', trans('app.object_forums')) !!}</li>
                </ul>
                <div class="right">
                    <a href="https://www.facebook.com/{{ Config::get('app.facebook') }}" target="_blank">{!! HTML::fontIcon('facebook') !!}</a>
                    <a href="https://twitter.com/{{ Config::get('app.twitter') }}" target="_blank">{!! HTML::fontIcon('twitter') !!}</a>
                    <a href="https://www.youtube.com/channel/{{ Config::get('app.youtube') }}" target="_blank">{!! HTML::fontIcon('youtube') !!}</a>
                </div>
            </div>
        </nav>
    </header>

    @widget('Slides::Slides', ['categoryId' => 1])

    <div class="divider"></div>
    <div class="container">
        <div id="mid-container" class="row">
            <div id="content" class="col-md-8">
                @if (Session::get('_alert'))
                    @include('alert', ['type' => 'info', 'title' => Session::get('_alert')])
                @endif

                <!-- Render JavaScript alerts here -->
                <div class="alert-area"></div>                

                <section class="page page-{!! strtolower($controllerName) !!} {!! $templateClass !!}">
                    @if (isset($page))
                        {!! $page !!}
                    @endif
                </section>
            </div>

            <aside id="sidebar" class="col-md-4">
                <div class="border">
					<br>
                    <h3>
                        Featured Cups
                        <a href="{{ url('cups') }}" title="{{ trans('app.read_more') }}">{!! HTML::fontIcon('plus') !!}</a>
                    </h3>
                    @widget('Cups::FeaturedCup')
					<h3>
						Cup Control
						<a href="{{ url('cups') }}" title="{{ trans('app.read_more') }}">{!! HTML::fontIcon('plus') !!}</a>
					</h3>
					@widget('Cups::CupsControl')
					<br>
                    <h3>
                        Recent Videos
						<a href="{{ url('videos') }}" title="{{ trans('app.read_more') }}">{!! HTML::fontIcon('plus') !!}</a>
                    </h3>
						@widget('Videos::Videos')
                </div>
            </aside>
        </div>
    </div>
    <footer id="footer">
        <div class="links">
            <div class="container">
                <nav>
                    <ul class="list-inline">
                        <li class="icon">{!! HTML::fontIcon('bars') !!}</li>
                        <li>{!! link_to('/', trans('app.home'), ['class' => 'active']) !!}</li>
                        
                        <li>{!! link_to('search', trans('app.object_search')) !!}</li>
                        <li>{!! link_to('awards', trans('app.object_awards')) !!}</li>
                        <li>{!! link_to('contact', trans('app.object_contact')) !!}</li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="more">
            <div class="container">
                <span class="info">&copy; {{ date('Y') }} by <a class="cms" href="{!! route('home') !!}">{!! Config::get('app.title') !!}</a></span>

                <span class="visitors-label">{{ trans('app.object_visitors') }}:&nbsp;&nbsp;</span>
                @widget('Visitors::Visitors')

                <div class="right">
                    <a href="https://www.facebook.com/{{ Config::get('app.facebook') }}" target="_blank" title="Facebook">{!! HTML::fontIcon('facebook') !!}</a>
                    <a href="https://twitter.com/{{ Config::get('app.twitter') }}" target="_blank" title="Twitter">{!! HTML::fontIcon('twitter') !!}</a>
                    <a href="https://www.youtube.com/channel/{{ Config::get('app.youtube') }}" target="_blank" title="YouTube">{!! HTML::fontIcon('youtube') !!}</a>
                </div>
            </div>
            </div> 
        </div>
    </footer>
    
    {!! Config::get('app.analytics') !!}
</body>
</html>