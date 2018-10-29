<?php namespace App\Modules\Teams;

use SoftDeletingTrait, BaseModel;

class Team extends BaseModel {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $slugable = true;

    protected $fillable = ['title', 'text', 'position', 'published', 'teamcat_id'];

    public static $fileHandling = ['image' => ['type' => 'image']];

    protected $rules = [
        'title'         => 'required|min:3',
        'position'      => 'sometimes|integer',
        'published'     => 'boolean',
        'teamcat_id'    => 'required|integer',
    ];

    public static $relationsData = [
        'matches'   => [
            self::HAS_MANY, 'App\Modules\Matches\Match', 'foreignKey' => 'left_team_id', 'dependency' => true
        ],
        'members'   => [self::BELONGS_TO_MANY, 'User'],
        'teamcat'   => [self::BELONGS_TO, 'App\Modules\Teams\Teamcat'],
        'awards'    => [self::HAS_MANY, 'App\Modules\Awards\Award', 'dependency' => true],
        'creator'   => [self::BELONGS_TO, 'User', 'title' => 'username'],
    ];

    /**
     * The BaseModel's handleRelationalArray() method does not support 
     * orderBy() for pivot attributes so we have to use oldschool Eloquent instead.
     */
    public function users()
    {
        return $this->belongsToMany('User')->withPivot('task', 'description', 'position')
            ->orderBy('pivot_position', 'asc');
    }

    /**
     * Select only those that have been published
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished($query)
    {
        return $query->wherePublished(true);
    }
    
}