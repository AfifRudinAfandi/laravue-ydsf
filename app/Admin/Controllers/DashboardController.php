<?php

namespace App\Admin\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController
{

  protected $title = 'Dashboard';

  public static function counter()
  {
    $totalDonasiSukses = DB::table('donations')->where('is_verified', 1)->sum('nominal');
    $totalCampaignComplete = DB::table('campaigns')->where('is_complete', '>', 0)->count();
    $totalCampaignProgress = DB::table('campaigns')->where([
      ['is_published', 1],
      ['is_complete', '<=', 0],
      ['max_time', '>=', Carbon::now()]
    ])->count();
    $totalCampaign = $totalCampaignComplete + $totalCampaignProgress;
    $totalUser = DB::table('users')->count();

    $output = [
      'totalDonationSuccess' => $totalDonasiSukses,
      'totalCampaignComplete' => $totalCampaignComplete,
      'totalCampaignProgress' => $totalCampaignProgress,
      'totalCampaign' => $totalCampaign,
      'totalUser' => $totalUser
    ];

    return view('admin.counter', $output);
  }
}
