<?php namespace App\Modules\Servers\Http\Controllers;

use ModelHandlerTrait;
use App\Modules\Servers\Server;
use Hover, HTML, BackController;

class AdminServersController extends BackController {

    use ModelHandlerTrait;

    protected $icon = 'database';

    public function __construct()
    {
        $this->modelName = 'Server';

        parent::__construct();
    }

    public function index()
    {
        $this->indexPage([
            'tableHead' => [
                trans('app.id')             => 'id', 
                trans('app.published')      => 'published', 
                trans('app.object_game')    => 'game_id', 
                trans('app.title')          => 'title',
                trans('app.ip')             => 'ip',
            ],
            'tableRow' => function($server)
            {
                $gameIcon = ($server->game and $server->game->icon) ?
                    HTML::image($server->game->uploadPath().$server->game->icon, $server->game->title) :
                    null;

                return [
                    $server->id,
                    raw($server->published ? HTML::fontIcon('check') : null),
                    raw($gameIcon),
                    raw(Hover::modelAttributes($server, ['creator'])->pull().HTML::link('servers', $server->title)),
                    $server->ip,
                ];            
            }
        ]);
    }

}