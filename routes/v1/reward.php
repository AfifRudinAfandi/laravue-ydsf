<?php

/**
 * User endpoint
 */
$router->group(['prefix' => 'rewards'], function () use ($router) {
  /** 
   * GET / : Get all data
   */
  $router->get('/', 'RewardController@getAll');

  /**
   * POST /create : Create new data
   */
  $router->post('/create', 'RewardController@create');

  /** 
   * PATCH /{id}/update : Edit specific blog by id
   */
  $router->patch('/{id}/update', 'RewardController@update');

  /** 
   * DELETE /{id}/delete : delete specific blog by id
   * DELETE /bulk-delete : delete all ny IDs
   */
  $router->delete('/{id}/delete', 'RewardController@delete');
  $router->delete('/bulk-delete', 'RewardController@bulkDelete');
});
