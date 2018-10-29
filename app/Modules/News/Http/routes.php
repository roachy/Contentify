<?php

ModuleRoute::context('News');

ModuleRoute::resource('admin/newscats', 'AdminNewscatsController');
ModuleRoute::get(
    'admin/newscats/{id}/restore', 
    ['as' => 'admin.newscats.restore', 'uses' => 'AdminNewscatsController@restore']
);
ModuleRoute::post('admin/newscats/search', 'AdminNewscatsController@search');

ModuleRoute::resource('admin/news', 'AdminNewsController');
ModuleRoute::get(
    'admin/news/{id}/restore', 
    ['as' => 'admin.news.restore', 'uses' => 'AdminNewsController@restore']
);
ModuleRoute::post('admin/news/search', 'AdminNewsController@search');

ModuleRoute::get('news', 'NewsController@index');
ModuleRoute::get('news/{id}/{slug?}', ['as' => 'news.show', 'uses' => 'NewsController@show'])
    ->where('id', '[0-9]+');
ModuleRoute::get('news/{slug}', 'NewsController@showBySlug');
ModuleRoute::get('news/showStream/{timestamp?}', 'NewsController@showStream')->where('timestamp', '[0-9]+');
ModuleRoute::post('news/search', 'NewsController@search');
