<?php

/**
 * Campaign endpoint (Campaign, Campaign Category, Campaign Progress)
 */
$router->group(['prefix' => 'campaigns'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{slug} : Get specific data by campaign's slug
   * GET /{id}/progress : Get all campaign's progress by Campaign ID
   * GET /categories : Get all categories
   */
  $router->get('/categories', 'CampaignController@getAllCategories');
  $router->get('/', 'CampaignController@getAllCampaign');
  $router->get('/{id}/id', 'CampaignController@getCampaignById');
  $router->get('/{slug}', 'CampaignController@getCampaignBySlug');
  $router->get('/{campaign_id}/progress', 'CampaignController@getProgressByCampaignId');
  $router->get('/progress/{id}', 'CampaignController@getProgressById');
  $router->get('/categories/{id}', 'CampaignController@getCategoryById');
  $router->get('/{campaign_id}/title', 'CampaignController@getCampaignTitle');

  /** 
   * POST /create : Add new campaign
   * POST /progress/create : Add new campaign's progress
   * POST /categories/create : Add new category
   */
  $router->post('/create', 'CampaignController@createCampaign');
  $router->post('/progress/create', 'CampaignController@createProgress');
  $router->post('/categories/create', 'CampaignController@createCategory');

  /** 
   * PATCH /{id}/update : Edit specific user by id
   * PATCH /progress/{id}/update : Update specific campaign progress
   * PATCH /categories/{id}/update : Update specific campaign progress
   */
  $router->patch('/{id}/update', 'CampaignController@updateCampaign');
  $router->patch('/progress/{id}/update', 'CampaignController@updateProgress');
  $router->patch('/categories/{id}/update', 'CampaignController@updateCategory');

  /** 
   * DELETE /{id}/delete : delete specific user by id
   */
  $router->delete('/{id}/delete', 'CampaignController@deleteCampaign');
  $router->delete('/bulk-delete', 'CampaignController@bulkDelete');
  $router->delete('/progress/{id}/delete', 'CampaignController@deleteProgress');
  $router->delete('/categories/{id}/delete', 'CampaignController@deleteCategory');
});
