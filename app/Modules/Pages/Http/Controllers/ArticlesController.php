<?php namespace App\Modules\Pages\Http\Controllers;

use App\Modules\Pages\Article;
use URL, HTML, FrontController;

class ArticlesController extends FrontController {

    public function __construct()
    {
        $this->modelName = 'Article';

        parent::__construct();
    }

    public function index()
    {
        $this->indexPage([
            'buttons'   => null,
            'tableHead' => [
                trans('app.title')      => 'title',
                trans('app.date')       => 'created_at'
            ],
            'tableRow'  => function($article)
            {
                return [
                    raw(HTML::link(URL::route('articles.show', [$article->id]), $article->title)),
                    $article->created_at
                ];
            },
            'actions'   => null,
            'filter'    => true
        ], 'front');
    }

    /**
     * Show an article
     * 
     * @param  int $id The id of the article
     * @return void
     */
    public function show($id)
    {
        $article = Article::whereId($id)->published()->firstOrFail();

        $hasAccess = (user() and user()->hasAccess('internal'));
        if ($article->internal and ! $hasAccess) {
            return $this->alertError(trans('app.access_denied'));
        }

        $article->access_counter++;
        $article->save();

        $this->title($article->title);
        $this->openGraph($article->openGraph());

        $this->title($article->title);
        $this->pageView('pages::show_article', compact('article'));
    }
    
    /**
     * This method is called by the global search (SearchController->postCreate()).
     * Its purpose is to return an array with results for a specific search query.
     * 
     * @param  string $subject The search term
     * @return string[]
     */
    public function globalSearch($subject)
    {
        $articles = Article::published()->where('title', 'LIKE', '%'.$subject.'%')->get();

        $results = array();
        foreach ($articles as $article) {
            $results[$article->title] = URL::to('articles/'.$article->id.'/show');
        }

        return $results;
    }

}