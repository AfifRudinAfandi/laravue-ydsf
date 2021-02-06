<?php

/**
 * Admin endpoint
 */
$router->group(['prefix' => 'admins'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{id} : Get specific admin by ID
   */
  $router->get('/', 'AdminController@getAll');
  $router->get('/{id}', 'AdminController@getById');

  /** 
   * POST / : Create new admin
   */
  $router->post('/create', 'AdminController@create');

  /** 
   * PATCH /{/id} : Edit specific user by id
   */
  $router->patch('/{id}/update', 'AdminController@update');

  /** 
   * DELETE /{id} : delete specific user by id
   */
  $router->delete('/{id}/delete', 'AdminController@delete');
});
