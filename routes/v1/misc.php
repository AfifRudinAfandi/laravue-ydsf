<?php

/**
 * Admin endpoint
 */
$router->group(['prefix' => 'misc'], function () use ($router) {
  /** 
   * GET / : Get all data count
   */
  $router->get('/count', function() {
    $totalDonasi = DB::table('donations')->sum('nominal');
    $totalDonasiSukses = DB::table('donations')->where('is_verified', 1)->sum('nominal');
    $totalCampaign = DB::table('campaigns')->count();
    $totalUser = DB::table('users')->count();

    $output = [
      'totalDonasi' => $totalDonasi,
      'donasiSukses' => $totalDonasiSukses,
      'totalCampaign' => $totalCampaign,
      'totalUser' => $totalUser
    ];

    return response()->json($output);
  });
});
