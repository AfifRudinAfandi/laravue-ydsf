<?php

/**
 * User endpoint
 */
$router->group(['prefix' => 'blogs'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{id} : Get specific blog by ID
   */
  $router->get('/', 'BlogController@getAll');
  $router->get('/{slug}', 'BlogController@getBySlug');
  $router->get('/{id}/id', 'BlogController@getById');

  /**
   * POST /create : Create new data
   */
  $router->post('/create', 'BlogController@create');

  /** 
   * PATCH /{id}/update : Edit specific blog by id
   */
  $router->patch('/{id}/update', 'BlogController@update');

  /** 
   * DELETE /{id}/delete : delete specific blog by id
   * DELETE /bulk-delete : delete all ny IDs
   */
  $router->delete('/{id}/delete', 'BlogController@delete');
  $router->delete('/bulk-delete', 'BlogController@bulkDelete');
});
