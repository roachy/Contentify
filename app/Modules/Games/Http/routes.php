<?php

ModuleRoute::context('Games');

ModuleRoute::resource('admin/games', 'AdminGamesController');
ModuleRoute::get(
    'admin/games/{id}/restore', 
    ['as' => 'admin.games.restore', 'uses' => 'AdminGamesController@restore']
);
ModuleRoute::post('admin/games/search', 'AdminGamesController@search');