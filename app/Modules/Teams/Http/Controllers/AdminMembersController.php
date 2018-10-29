<?php namespace App\Modules\Teams\Http\Controllers;

use App\Modules\Teams\Team;
use Redirect, Input, Response, View, HTML, DB, User, BackController;

class AdminMembersController extends BackController {

    protected $icon = 'group';

    public function __construct()
    {
        $this->modelName = '\User';

        parent::__construct();
    }

    public function getIndex()
    {
        $this->indexPage([
            'buttons'   => null,
            'tableHead' => [
                trans('app.id')             => 'id', 
                trans('app.username')       => 'username',
                trans('app.object_teams')   => null,
            ],
            'tableRow' => function($user)
            {
                $data = [];
                foreach ($user->teams as $team) {
                    $data[$team->id] = e($team->title);
                }

                return [
                    $user->id,
                    $user->username,
                    raw('<div class="data" data-user-id="'.$user->id.'">'.json_encode($data).'</div>'),
                ];            
            },
            'searchFor' => 'username',
            'actions'   => null
        ]);
        
        $this->pageOutput(HTML::script('vendor/contentify/members.js'));
    }

    /**
     * Delete a team membership
     * 
     * @param  int $userId
     * @param  int $teamId
     * @return Response
     */
    public function deleteDelete($userId, $teamId)
    {
        $user = User::findOrFail($userId);

        DB::table('team_user')->whereUserId($userId)->whereTeamId($teamId)->delete();

        $data = [];
        foreach ($user->teams as $team) {
            $data[$team->id] = $team->title;
        }

        return json_encode($data);
    }

    /**
     * Return form for joining a team
     * 
     * @param  int $userId
     * @return Response
     */
    public function getAdd($userId)
    {
        $ids = DB::table('team_user')->whereUserId($userId)->lists('team_id');

        if (sizeof($ids) > 0) {
            $teams = Team::whereNotIn('id', $ids)->get();
        } else {
            $teams = Team::all();
        }
            
        if (sizeof($teams) > 0) {
            return View::make('teams::admin_members_team', compact('teams', 'user'));
        } else {
            return Response::make('');
        }       
    }

    /**
     * Create a team membership
     * 
     * @param  int $userId
     * @param  int $teamId
     * @return Response
     */
    public function postAdd($userId, $teamId)
    {
        $user = User::findOrFail($userId);

        DB::table('team_user')->insert([
            'team_id'       => $teamId, 
            'user_id'       => $userId,
        ]);

        $data = [];
        foreach ($user->teams as $team) {
            $data[$team->id] = $team->title;
        }

        return json_encode($data);
    }

    /**
     * Return form for team membership details
     * 
     * @param  int $userId
     * @param  int $teamId
     * @return Response
     */
    public function getEdit($userId, $teamId)
    {
        $user = User::findOrFail($userId);

        foreach ($user->teams as $team) {
            if ($team->id == $teamId) {
                return View::make('teams::admin_members_edit', compact('team'));
            }
        }
        
        return Response::make(400);
    }

    /**
     * Update team membership details
     * 
     * @param  int $userId
     * @param  int $teamId
     * @return Response
     */
    public function postUpdate($userId, $teamId)
    {
        $task           = Input::get('task');
        $description    = Input::get('description');
        $position       = (int) Input::get('position');

        DB::table('team_user')->whereUserId($userId)->whereTeamId($teamId)->update([
            'task'          => $task,
            'description'   => $description,
            'position'      => $position,
        ]);

        return Response::make(1);
    }

    /**
     * Helper action method for searching. All we do here is to redirect with the input.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSearch()
    {
        return Redirect::to('admin/members')->withInput(Input::only('search'));
    }

}