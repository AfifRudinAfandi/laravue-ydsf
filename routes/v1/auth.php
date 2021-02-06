<?php

/**
 * Auth enpoint
 */
$router->group(['prefix' => 'auth'], function () use ($router) {
  /**
   * POST /{user}/login : Login for admin or user 
   * POST /{user}/register : Register admin or user 
   */
  $router->post('/admin/login', 'AuthController@loginByEmail');
  $router->post('/admin/register', 'AuthController@register');

  /**
   * GET /verif/{token} : Verif email by token
   */
  $router->get('/verif/{token}', 'AuthController@verif');

  /**
   * DELETE /logout : Clear auth token 
   */
  $router->delete('/logout', 'AuthController@logout');
});
