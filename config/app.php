<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'env' => env('APP_ENV', 'development'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application Title
    |--------------------------------------------------------------------------
    |
    | The name of this web application.
    |
    */

    'title' => 'World Super Leagues',

    /*
    |--------------------------------------------------------------------------
    | CMS Version
    |--------------------------------------------------------------------------
    |
    | The CMS version.
    |
    */

    'version' => '2.1',

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'https://worldsuperleagues.com'),

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | Items per page, etc.
    |
    */

    'frontItemsPerPage' => 10,
    'adminItemsPerPage' => 10,

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you should specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    | Example value for CET: 'Europe/Berlin'
    |
    */

    'timezone' => 'Europe/London',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', '01234567890123456789012345678912'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    /*
    |--------------------------------------------------------------------------
    | Google ReCAPTCHA Secret
    |--------------------------------------------------------------------------
    |
    | If you use Google ReCAPTCHA to protect your website from bots,
    | this is the place to enter the server secret.
    |
    */

    'recaptcha_secret' => '',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Broadcasting\BroadcastServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        //'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',

        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider',
        'App\Providers\ConfigServiceProvider',
        'App\Providers\EventServiceProvider',
        'App\Providers\RouteServiceProvider',

        /*
         * CMS service prodivers:
         */
        'Contentify\ServiceProviders\HtmlServiceProvider',
        'Contentify\ServiceProviders\TranslationServiceProvider',
        'Contentify\ServiceProviders\HoverServiceProvider',
        'Contentify\ServiceProviders\ModuleRouteServiceProvider',
        'Contentify\ServiceProviders\ContentFilterServiceProvider',
        'Contentify\ServiceProviders\CaptchaServiceProvider',
        'Contentify\ServiceProviders\CommentsServiceProvider',
        'Contentify\ServiceProviders\RatingsServiceProvider',
        'Contentify\ServiceProviders\UserActivitiesServiceProvider',
        'Contentify\ServiceProviders\ModelHandlerServiceProvider',

        /*
         * Vendor service providers:
         */
        'ChrisKonnertz\Jobs\JobsServiceProvider',
        'Caffeinated\Modules\ModulesServiceProvider',
        'Cartalyst\Sentinel\Laravel\SentinelServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Invisnik\LaravelSteamAuth\SteamServiceProvider',
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'                   => 'Illuminate\Support\Facades\App',
        'Artisan'               => 'Illuminate\Support\Facades\Artisan',
        'Auth'                  => 'Illuminate\Support\Facades\Auth',
        'Blade'                 => 'Illuminate\Support\Facades\Blade',
        'Bus'                   => 'Illuminate\Support\Facades\Bus',
        'Cache'                 => 'Illuminate\Support\Facades\Cache',
        //'Config'                => 'Illuminate\Support\Facades\Config',
        'Cookie'                => 'Illuminate\Support\Facades\Cookie',
        'Crypt'                 => 'Illuminate\Support\Facades\Crypt',
        'DB'                    => 'Illuminate\Support\Facades\DB',
        'Eloquent'              => 'Illuminate\Database\Eloquent\Model',
        'Event'                 => 'Illuminate\Support\Facades\Event',
        'File'                  => 'Illuminate\Support\Facades\File',
        'Hash'                  => 'Illuminate\Support\Facades\Hash',
        'Input'                 => 'Illuminate\Support\Facades\Input',
        'Inspiring'             => 'Illuminate\Foundation\Inspiring',
        'Lang'                  => 'Illuminate\Support\Facades\Lang',
        'Log'                   => 'Illuminate\Support\Facades\Log',
        'Mail'                  => 'Illuminate\Support\Facades\Mail',
        'Password'              => 'Illuminate\Support\Facades\Password',
        'Queue'                 => 'Illuminate\Support\Facades\Queue',
        'Redirect'              => 'Illuminate\Support\Facades\Redirect',
        'Redis'                 => 'Illuminate\Support\Facades\Redis',
        'Request'               => 'Illuminate\Support\Facades\Request',
        'Response'              => 'Illuminate\Support\Facades\Response',
        'Route'                 => 'Illuminate\Support\Facades\Route',
        'Schema'                => 'Illuminate\Support\Facades\Schema',
        'Session'               => 'Illuminate\Support\Facades\Session',
        'SoftDeletingTrait'     => 'Illuminate\Database\Eloquent\SoftDeletes',
        'Storage'               => 'Illuminate\Support\Facades\Storage',
        'Str'                   => 'Illuminate\Support\Str',
        'URL'                   => 'Illuminate\Support\Facades\URL',
        'Validator'             => 'Illuminate\Support\Facades\Validator',
        'View'                  => 'Illuminate\Support\Facades\View',

        'Controller'            => 'App\Http\Controllers\Controller',
        'Form'                  => 'Collective\Html\FormFacade',
        'HTML'                  => 'Collective\Html\HtmlFacade',

        /*
         * CMS classes:
         */ 
        'FormGenerator'         => 'Contentify\FormGenerator',
        'ModuleInstaller'       => 'Contentify\ModuleInstaller',
        'MsgException'          => 'Contentify\MsgException',
        'Config'                => 'Contentify\Config',
        'Paginator'             => 'Contentify\LengthAwarePaginator',
        'ModuleRoute'           => 'Contentify\Facades\ModuleRoute',
        'Carbon'                => 'Contentify\Carbon',

        'DateAccessorTrait'     => 'Contentify\Traits\DateAccessorTrait',
        'ModelHandlerTrait'     => 'Contentify\Traits\ModelHandlerTrait',

        'InstallController'     => 'Contentify\Controllers\InstallController',
        'BaseController'        => 'Contentify\Controllers\BaseController',
        'FrontController'       => 'Contentify\Controllers\FrontController',
        'BackController'        => 'Contentify\Controllers\BackController',
        'ConfigController'      => 'Contentify\Controllers\ConfigController',
        'Widget'                => 'Contentify\Controllers\Widget',

        'BaseModel'             => 'Contentify\Models\BaseModel',
        'Comment'               => 'Contentify\Models\Comment',
        'StiModel'              => 'Contentify\Models\StiModel',
        'User'                  => 'Contentify\Models\User',
        'UserActivity'          => 'Contentify\Models\UserActivity',
        'ConfigBag'             => 'Contentify\Models\ConfigBag',
        'Raw'                   => 'Contentify\Raw',

        /*
         * Vendor classes:
         */
        'OpenGraph'             => 'ChrisKonnertz\OpenGraph\OpenGraph',
        'BBCode'                => 'ChrisKonnertz\BBCode\BBCode',
        'Jobs'                  => 'ChrisKonnertz\Jobs\JobsFacade',
        'Job'                   => 'ChrisKonnertz\Jobs\Job',
        'Sentinel'              => 'Cartalyst\Sentinel\Laravel\Facades\Sentinel',
        'Activation'            => 'Cartalyst\Sentinel\Laravel\Facades\Activation',
        'Reminder'              => 'Cartalyst\Sentinel\Laravel\Facades\Reminder',
        'Rss'                   => 'Thujohn\Rss\RssFacade',
        'InterImage'            => 'Intervention\Image\Facades\Image',
        'ValidatingTrait'       => 'Watson\Validating\ValidatingTrait',
    ],

];
