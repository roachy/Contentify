<?php namespace App\Modules\Users;

use User as BaseUser;
use BaseModel;

/**
 * NOTE: This is a helper class that extends the actual user class.
 */
class User extends BaseUser {

    protected $fillable = ['banned', 'relation_roles', 'relation_teams'];

    protected $slugable = true;

    public static $relationsData = [
        'roles'     => [BaseModel::BELONGS_TO_MANY, 'App\Modules\Roles\Role', 'table' => 'role_users'],
        'teams'     => [BaseModel::BELONGS_TO_MANY, 'App\Modules\Teams\Team', 'table' => 'team_user'],
        'cup_teams'     => [BaseModel::BELONGS_TO_MANY, 'App\Modules\Cups\Team', 'table' => 'cups_teams'],
        'matches'     => [BaseModel::HAS_MANY, 'App\Modules\Cups\Match', 'table' => 'cups_matches'],
    ];
	
    /**
     * Getter for $relationsData.
     * NOTE: This model does not inherit from BaseModel.
     * The relations method is used to copy some of the BaseModel's behaviour.
     * 
     * @return array
     */
    public static function relations()
    {
        return static::$relationsData;
    }
	


    /**
     * This is a copy of a BaseModel method (for compatibility).
     * 
     * @return bool
     */
    public function modifiable()
    {
        return true;
    }
	
	public function checkForUser()
	{
		if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }
	}

}