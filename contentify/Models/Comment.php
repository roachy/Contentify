<?php namespace Contentify\Models;

use Cache, SoftDeletingTrait, BBCode;

class Comment extends BaseModel {

    use SoftDeletingTrait;

    const CACHE_KEY = 'comments::comment.';

    protected $fillable = array('text');

    public $rules = array(
        'text'  => 'required|min:3',
    );

    public static $relationsData = array(
        'creator' => array(self::BELONGS_TO, 'User'),
    );

    public static function boot()
    {
        parent::boot();

        self::saved(function ($comment)
        {
            $comment->cache();
        });
    }

    /**
     * Caches this comment - we don't want to parse BBCodes each time
     * we want to display a comment.
     * 
     * @return void
     */
    public function cache()
    {
        $bbcode = new BBCode();
        $rendered = $bbcode->render($this->text);
        $rendered = emojis($rendered);
        Cache::put(self::CACHE_KEY.$this->id, $rendered, 60);
    }

    /**
     * Counts the comments that are related to a certain foreign type (model).
     * NOTE: The result of the database query is cached!
     * 
     * @param  string   $foreignType Name of the foreign type (model)
     * @param  int      $foreignId   ID of the foreign type or null
     * @return int
     */
    public static function count($foreignType, $foreignId = null)
    {
        $key = 'comments.countByModel.'.$foreignType.'.'.$foreignId;

        return Cache::remember($key, 5, function() use ($foreignType, $foreignId)
        {
            $query = self::whereForeignType($foreignType);
            if ($foreignId) $query->whereForeignId($foreignId);

            return $query->count();
        });
    }

    /**
     * Renders the comment's text (with BBCode converted to HTML code)
     * 
     * @return string
     */
    public function renderText()
    {
        $key = self::CACHE_KEY.$this->id;

        if (! Cache::has($key)) {
            $this->cache();
        }

        return Cache::get($key);
    }

    /**
     * Return just the plain comment text (WITHOUT BBCode).
     * (Similar to render BBCode without the tags but it uses caching.)
     *
     * @param int $max Limits the number of characters. 0/null = no limit
     * @return string
     */
    public function plainText($max = null)
    {
        $text = strip_tags($this->renderText());

        if ($max) {
            if (strlen($text) > $max) {
                $text = substr($text, 0, $max).'...';
            }
        }

        return $text;
    }

}