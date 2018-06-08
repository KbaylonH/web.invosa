<?php

Route::group(['middleware'=>['guest']], function($route){

  $route->get('/login', 'Auth\LoginController@index')->name('login');
  $route->get('/redirect', 'Auth\LoginController@login');
  $route->get('/callback', 'Auth\LoginController@callback');
});

Route::group(['middleware'=>['auth']], function($route){

  $route->get('/', 'HomeController@index')->name("main");
  //$route->get('/minor', 'HomeController@minor')->name("minor");
  $route->get('/route', 'RouteController@index')->name('route');
  $route->get('/route/search', 'RouteController@search');
  $route->post('/route/import', 'RouteController@import');
  $route->post('/route', 'RouteController@insert');
});
