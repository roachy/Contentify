<?php namespace App\Modules\Cups\Http\Controllers;

use App\Modules\Cups\Cup;
use App\Modules\Cups\Team;
use View, Widget;

class TeamsControlWidget extends Widget {

    public function render($parameters = array())
    {
        $team = new Team;
        $teams = $team->teamsOfUser(user()->id);
        return View::make('cups::widget_team_control', compact('teams'))->render();
    }

}