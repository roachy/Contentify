<?php namespace App\Modules\Users\Http\Controllers;

use User, View, Widget;

class LatestUsersWidget extends Widget {

    public function render($parameters = array())
    {
    	$limit = isset($parameters['limit']) ? (int) $parameters['limit'] : self::LIMIT;

        $users = User::orderBy('created_at', 'DESC')->take($limit)->get();

        return View::make('users::widget_latest_users', compact('users'))->render();
    }

}