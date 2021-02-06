<?php

/**
 * User endpoint
 */
$router->group(['prefix' => 'users'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{id} : Get specific user by id
   */
  $router->get('/', 'UserController@getAll');
  $router->get('/{id}', 'UserController@getById');

  /**
   * POST /create : Create new data
   */
  $router->post('/create', 'UserController@create');

  /** 
   * PATCH /{id}/update : Edit specific user by id
   */
  $router->patch('/{id}/update', 'UserController@update');
  $router->patch('/{id}/update/password', 'UserController@updatePassword');
  $router->patch('/{id}/update/status', 'UserController@updateStatus');
  $router->patch('/{id}/update/display-name/{show}', 'UserController@updateDisplayName');

  /** 
   * DELETE /{id}/delete : delete specific user by id
   */
  $router->delete('/{id}/delete', 'UserController@delete');
});
