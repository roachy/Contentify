<?php

ModuleRoute::context('Pages');

ModuleRoute::resource('admin/pages', 'AdminPagesController');
ModuleRoute::get(
    'admin/pages/{id}/restore', 
    ['as' => 'admin.pages.restore', 'uses' => 'AdminPagesController@restore']
);
ModuleRoute::post('admin/pages/search', 'AdminPagesController@search');

ModuleRoute::get('pages/{id}/{slug?}', ['as' => 'pages.show', 'uses' => 'CustomPagesController@show'])
    ->where('id', '[0-9]+');
ModuleRoute::get('pages/{slug}', ['as' => 'pages.showSlug', 'uses' => 'CustomPagesController@showBySlug']);
ModuleRoute::get('terms-conditions', ['as' => 'pages.showTerms', 'uses' => 'CustomPagesController@showTerms']);

ModuleRoute::get('articles', 'ArticlesController@index');
ModuleRoute::get('articles/{id}', ['as' => 'articles.show', 'uses' => 'ArticlesController@show']);
ModuleRoute::get('articles/{id}/{slug}', 'ArticlesController@show');

ModuleRoute::get('editor-templates/{id}', 'EditorTemplatesController@show');
ModuleRoute::get('editor-templates', 'EditorTemplatesController@index');