<?php namespace App\Modules\Cups\Http\Controllers;

use App\Modules\Cups\Cup;
use App\Modules\Cups\Team;
use URL, Response, DB, Validator, HTML, Str, Redirect, Input, User, View, FrontController;

class TeamsController extends FrontController {

    public function __construct()
    {
        $this->modelName = 'Team';

        parent::__construct();
    }
	
	public function index()
    {
       $teams = Team::paginate(12);
	   $user = user();
	   $this->pageView('cups::teams_index', compact('teams', 'user'));
    }

    public function overview($userId)
    {
        $user = User::findOrFail($userId);
        $teams = (new Team())->teamsOfUser($user);

        $this->pageView('cups::teams_overview', compact('user', 'teams'));
    }

    /**
     * Shows a cup team
     * 
     * @param  int  $id The ID of the team
     * @return void
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
		$count = Team::get()->count();
        $organizer = user() ? $team->isOrganizer(user()) : false;

        $this->title($team->title);

        $this->pageView('cups::show_team', compact('team', 'organizer'));
    }

    /**
     * Changes the organizer right of a team member
	 *
     * @param  int $teamId
     * @param  int $userId
     * @return Response|null
     */
    public function organizer($teamId, $userId)
    {
        $team = Team::findOrFail($teamId);
        $user = User::findOrFail($userId);
        \Log::error(Input::get('organizer'));
        $isOrganizer = (bool) Input::get('organizer');

        if (! user()) {
            return Response::make(trans('app.no_auth'), 403); // 403: Not allowed
        }

        if ($team->isOrganizer(user()) or user()->isSuperAdmin()) {
            if (! $isOrganizer and sizeof($team->organizers) == 1) {
                return Response::make(trans('cups::min_organizers'), 403); // 403: Not allowed
            }

            DB::table('cups_team_members')->whereTeamId($teamId)->whereUserId($userId)
                ->update(['organizer' => $isOrganizer]);

            return Response::make(null, 200);
        } else {
            return Response::make(trans('app.access_denied'), 403); // 403: Not allowed
        }
    }

    /**
     * User wants to join a team.
     * 
     * @param  int $teamId The team ID
     * @return Redirect
     */
    public function join($teamId) 
    {
        $team = Team::findOrFail($teamId);

        if (! user() or $team->isMember(user())) {
            $this->alertError(trans('app.not_possible'));
            return;
        }

        if ($team->isLocked()) {
            $this->alertError(trans('cups::team_locked'));
            return;
        }

        if ($team->password) {
            $password = Input::get('password');

            if ($password === null) {
                $this->pageView('cups::password_form', compact('team'));
                return;
            }

            if ($password !== $team->password) {
                return Redirect::to('cups/teams/join/'.$teamId)->withErrors(trans('cups::wrong_password'));
            }
        }

        DB::table('cups_team_members')->insert(['team_id' => $team->id, 'user_id' => user()->id]);

        $this->alertFlash(trans('app.successful'));
        return Redirect::to('cups/teams/'.$team->id.'/'.$team->slug);
    }
	
	 /**
     * Allows users to be invited to a team
     * 
     * @param  int  $teamId The ID of the team
     * @param  int  $userId The ID of the user
     * @return void
     */
	public function invite($teamId, $userId)
	{
		// Pull these as we need information from both models
		$team = Team::find($teamId);
		$user = User::find($userId);
		
		
		
	}
	

    /**
     * Makes a user leave a cup team
     * 
     * @param  int  $teamId The ID of the team
     * @param  int  $userId The ID of the user
     * @return void
     */
    public function leave($teamId, $userId)
    {
        $team = Team::findOrFail($teamId);
        $user = User::findOrFail($userId);

        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        $organizer = $team->isOrganizer(user());

        if (user()->id == $userId or $organizer or user()->isSuperAdmin()) {
            if ($team->isLocked()) {
                $this->alertError(trans('cups::team_locked'));
                return;
            }

            if (sizeof($team->organizers) == 1) {
                foreach ($team->organizers as $organizer) {
                    if ($organizer->id == $userId) {
                        $this->alertError(trans('cups::min_organizers'));
                        return;
                    }
                }
            }

            $team->removeMembers([$userId]);

            $this->alertFlash(trans('app.successful'));
            return Redirect::to('cups/teams/'.$team->id.'/'.$team->slug);
        } else {
            $this->alertError(trans('app.access_denied'));
            return;
        }
    }

    /**
     * Shows a form that allows the user to create a team.
     * 
     * @param  int $teamId The ID of the team
     * @return void
     */
    public function create()
    {
        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        $this->pageView('cups::team_form', ['team' => null]);
    }

    /**
     * Creates a new team.
     * 
     * @return Redirect
     */
    public function store()
    {
        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        $team = new Team;

        $team->title = trim(Input::get('title'));
        $team->platform = trim(Input::get('platform'));
        $team->createSlug();
        $team->password = Input::get('password');
        $team->creator_id = user()->id;
        
        $okay = $team->save();
        if (! $okay) {
            return Redirect::to('cups/teams/create')->withInput()->withErrors($team->getErrors());
        }
        $tmp = $team->id; // We need to do that to force Eloquent to refresh the id attribute.
        
        $team->addMember(user(), true);

        $result = $team->uploadFile('image', true);
        if ($result) {
            return Redirect::to('cups/teams/edit/'.$team->id)->withInput()->withErrors($result);
        }

        $this->alertFlash(trans('app.successful'));
        return Redirect::to('cups/teams/'.$team->id.'/'.$team->slug);
    }

    /**
     * Shows a form that allows the user to edit a team.
     * 
     * @param  int $id The ID of the team
     * @return void
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        
        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        if ($team->isOrganizer(user()) or user()->isSuperAdmin()) {
            $this->pageView('cups::team_form', compact('team'));
        } else {
            $this->alertError(trans('app.access_denied'));
            return;
        }        
    }

    /**
     * Updates the team
     *
     * @param  int $id The ID of the team
     * @return Redirect
     */
    public function update($id)
    {
        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        $team = Team::findOrFail($id);
        $team->title = trim(Input::get('title'));
        $team->platform = trim(Input::get('platform'));
        $team->platoon_tag = trim(Input::get('platoon_tag'));
        $team->createSlug();
        $team->password = Input::get('password');
        $team->updater_id = user()->id;

        $okay = $team->save();
        if (! $okay) {
            return Redirect::to('cups/teams/edit/'.$id)->withInput()->withErrors($team->getErrors());
        }

        $result = $team->uploadFile('image', true);
        if ($result) {
            return Redirect::to('cups/teams/edit/'.$id)->withInput()->withErrors($result);
        }

        $this->alertFlash(trans('app.successful'));
        return Redirect::to('cups/teams/'.$team->id.'/'.$team->slug);
    }

    /**
     * Deletes a team.
     * 
     * @param  int $id The ID of the team
     * @return Redirect
     */
    public function delete($id)
    {
        if (! user()) {
            $this->alertError(trans('app.no_auth'));
            return;
        }

        $team = Team::findOrFail($id);

        if ($team->isLocked()) {
            $this->alertError(trans('app.team_locked'));
            return;
        }

        if ($team->isOrganizer(user()) or user()->isSuperAdmin()) {
            $team->hidden = true;
            $team->title = 'Deleted';
            $team->createSlug();
            $team->forceSave();
            $team->removeMembers();
            $this->alertSuccess(trans('app.successful'));
            return Redirect::to('cups/teams/overview/');
        } else {
            $this->alertError(trans('app.access_denied'));
            return;
        }       
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
            $results[$team->title] = URL::to('cups/teams/overview/'.$team->id.'/'.$team->slug);
        }

        return $results;
    }

}
