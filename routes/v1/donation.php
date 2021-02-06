<?php

/**
 * User endpoint
 */
$router->group(['prefix' => 'donations'], function () use ($router) {
  /** 
   * GET / : Get all data
   * GET /{id} : Get specific donation by id
   */
  $router->get('/', 'DonationController@getAllDonation');
  $router->get('/{id}', 'DonationController@getDonationById');
  $router->get('/campaign/{campaign_id}/', 'DonationController@getByCampaignId');
  $router->get('/user/{user_id}', 'DonationController@getByUserId');

  /**
   * POST /create : Create new data
   */
  $router->post('/create', 'DonationController@create');

  /** 
   * PATCH /{id}/update : Edit specific donation by id
   * PATCH /{uuid}/update : Verif specific donation by id
   */
  $router->patch('/{id}/update', 'DonationController@update');
  $router->patch('/{uuid}/verification', 'DonationController@verification');

  /** 
   * DELETE /{id}/delete : delete specific donation by id
   * DELETE /bulk-delete : delete all ny IDs
   */
  $router->delete('/{id}/delete', 'DonationController@delete');
  $router->delete('/bulk-delete', 'DonationController@bulkDelete');
});
