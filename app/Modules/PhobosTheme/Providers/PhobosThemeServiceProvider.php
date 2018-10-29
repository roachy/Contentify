<?php namespace App\Modules\PhobosTheme\Providers;

use Illuminate\Support\ServiceProvider;
use App, Lang, View;

class PhobosThemeServiceProvider extends ServiceProvider {

    protected $namespace = 'phobosTheme';

    public function register()
    {
        View::addNamespace($this->namespace, realpath(__DIR__.'/../Resources/Views'));
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Resources/Assets/css' => public_path('css'),
        ], $this->namespace);
    }

}