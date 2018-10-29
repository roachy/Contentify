<?php namespace App\Modules\Cups;

use DB, BaseModel;

class Team extends BaseModel {

    public $table = 'cups_teams';

    protected $uploadDir = 'cups_teams';

    protected $slugable = true;

    protected $fillable = ['title', 'tag', 'platform', 'password'];

    public static $fileHandling = ['image' => ['type' => 'image']];

    protected $rules = [
        'title'  => 'required|min:3|max:20',
    ];

    /**
     * Relationship: Returns all cups of this team
     * 
     * @return Collection
     */
    public function cups() 
    {
        return $this->belongsToMany('App\Modules\Cups\Cup', 'cups_participants', 'participant_id')
            ->where('players_per_team', '>', 1);
    }

    /**
     * Relationship: Returns all members of this team with their "organizer" attribute.
     * 
     * @return Collection
     */
    public function members() 
    {
        return $this->belongsToMany('User', 'cups_team_members')->withPivot('organizer');
    }

    /**
     * Relationship: Returns all members which are organizers.
     * 
     * @return Collection
     */
    public function organizers() 
    {
        return $this->belongsToMany('User', 'cups_team_members')->withPivot('organizer')
            ->where('cups_team_members.organizer', '=', true);
    }

    /**
     * Counts the members of this team.
     * 
     * @return int
     */
    public function countMembers()
    {
        return DB::table('cups_team_members')->whereTeamId($this->id)->count();
    }

    /**
     * Returns true if a given user is organizer in this team.
     * 
     * @param  User $user
     * @return bool
     */
    public function isOrganizer($user)
    {
        $membership = DB::table('cups_team_members')->whereTeamId($this->id)->whereUserId($user->id)
            ->whereOrganizer(true)->first();

        return ($membership !== null);
    }

    /**
     * Returns the teams of a given user. Also returns the membership attributes (e. g. "organizer").
     * 
     * @param  User $user
     * @return Collection
     */
    public function teamsOfUser($user)
    {
        return self::join('cups_team_members', 'cups_team_members.team_id', '=', 'cups_teams.id')->
            where('cups_team_members.user_id', '=', $user->id)->get();
    }

    /**
     * Returns true if a user is member of this team.
     * 
     * @param  User  $user
     * @return boolean
     */
    public function isMember($user)
    {
        foreach ($this->members as $member) {
            if ($member->id == $user->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the team is locked. This means the team is in a cup that is 
     * not closed and no member is allowed to leave and no user is allowed to join.
     * TODO: Maybe only check for cups that already are in the join phase?
     * 
     * @return boolean
     */
    public function isLocked()
    {
        $result = DB::table('cups')->where('players_per_team', '>', 1)->whereClosed(false)
            ->join('cups_participants', 'cups.id', '=', 'cups_participants.cup_id')->whereParticipantId($this->id)->first();
        return ($result !== null);
    }    
	
    /**
     * Adds a member to a team. Does not validate anything!
     * 
     * @param User    $user      The user object
     * @param boolean $organizer Is the user an organizer?
     */
    public function addMember($user, $organizer = false)
    {
        DB::table('cups_team_members')->insert([
            'team_id'   => $this->id, 
            'user_id'   => $user->id, 
            'organizer' => $organizer,
        ]);
    }

    /**
     * Removes members from this team:
     * - If an array with member IDs is passed, remove these members.
     * - If no parameter is passed, remove all(!) members.
     *
     * @param array $memberIds Array with IDs of them members
     * @return void
     */
    public function removeMembers($memberIds = array())
    {
        if (sizeof($memberIds) == 0) {
            $memberIds = DB::table('cups_team_members')->whereTeamId($this->id)->lists('user_id'); // Get all members
        }

        //$cupIds = DB::table('cups_participants')->whereTeamId($this->id)->lists('team_id'); // Get all cups

        // The members do no longer participate in the cups of the team. Not even in the old (closed) cups.
        //DB::enableQueryLog();
        // TODO: Test this!
        DB::table('cups_users')->whereIn('user_id', $memberIds)
            ->join('cups_participants', 'cups_users.cup_id', '=', 'cups_participants.cup_id')->where('cups_participants.participant_id', '=', $this->id)->delete();
        //dd(DB::getQueryLog());

        // Remove members from the team
        DB::table('cups_team_members')->whereTeamId($this->id)->whereIn('user_id', $memberIds)->delete();
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
        $teams = Team::where('title', 'LIKE', '%'.$subject.'%')->get();

        $results = array();
        foreach ($teams as $team) {
            $results[$team->title] = url('cups/teams/'.$team->id.'/'.$team->slug);
        }

        return $results;
    }

}