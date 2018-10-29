<?php namespace App\Modules\Videos\Http\Controllers;

use ModelHandlerTrait;
use App\Modules\Videos\Video;
use Hover, HTML, BackController;

class AdminVideosController extends BackController {

    use ModelHandlerTrait;

    protected $icon = 'youtube-play';

    public function __construct()
    {
        $this->modelName = 'Video';

        parent::__construct();
    }

    public function index()
    {
        $this->indexPage([
            'tableHead' => [
                trans('app.id')         => 'id', 
                trans('app.title')      => 'title',
                trans('app.provider')   => 'provider',
            ],
            'tableRow' => function($video)
            {
                Hover::modelAttributes($video, ['creator']);

                return [
                    $video->id,
                    raw(Hover::pull().HTML::link('videos/'.$video->id.'/'.$video->slug, $video->title)),
                    Video::$providers[$video->provider],
                ];            
            }
        ]);
    }

}