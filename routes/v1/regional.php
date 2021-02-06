<?php

/**
 * User endpoint
 */
$router->group(['prefix' => 'regionals'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{id} : Get specific data by id
   */
  $router->get('/', 'RegionalController@getAll');
  $router->get('/{id}', 'RegionalController@getById');

  /** 
   * POST /create : Add new regional
   */
  $router->post('/create', 'RegionalController@create');

  /** 
   * PATCH /{id}/update : Edit specific user by id
   */
  $router->patch('/{id}/update', 'RegionalController@update');

  /** 
   * DELETE /{id}/delete : delete specific user by id
   */
  $router->delete('/{id}/delete', 'RegionalController@delete');
});
