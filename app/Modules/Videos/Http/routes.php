<?php

ModuleRoute::context('Videos');

ModuleRoute::resource('admin/videos', 'AdminVideosController');
ModuleRoute::get(
    'admin/videos/{id}/restore', 
    ['as' => 'admin.videos.restore', 'uses' => 'AdminVideosController@restore']
);
ModuleRoute::post('admin/videos/search', 'AdminVideosController@search');

ModuleRoute::resource('videos', 'VideosController', ['only' => ['index', 'show']]);
ModuleRoute::get('videos/{id}/{slug}', 'VideosController@show');
ModuleRoute::post('videos/search', 'VideosController@search');