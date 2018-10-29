<?php

ModuleRoute::context('Countries');

ModuleRoute::resource('admin/countries', 'AdminCountriesController');
ModuleRoute::get(
    'admin/countries/{id}/restore', 
    ['as' => 'admin.countries.restore', 'uses' => 'AdminCountriesController@restore']
);
ModuleRoute::post('admin/countries/search', 'AdminCountriesController@search');
