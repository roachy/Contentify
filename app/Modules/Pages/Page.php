<?php namespace App\Modules\Pages;

use SoftDeletingTrait, StiModel;

class Page extends StiModel {

    use SoftDeletingTrait;

    protected $table = 'pages';

    protected $subclassField = 'pagecat_id';

    protected $dates = ['deleted_at, published_at'];

    protected $slugable = true;

    protected $fillable = [
        'title', 
        'text', 
        'published_at', 
        'published',
        'internal',
        'enable_comments',
        'pagecat_id'
    ];

    protected $rules = [
        'title'             => 'required|min:3',
        'published'         => 'boolean',
        'internal'          => 'boolean',
        'enable_comments'   => 'boolean',
        'pagecat_id'        => 'required|integer'
    ];

    public static $relationsData = [
        'pagecat' => [self::BELONGS_TO, 'App\Modules\Pages\Pagecat'],
        'creator' => [self::BELONGS_TO, 'User', 'title' => 'username'],
    ];

}