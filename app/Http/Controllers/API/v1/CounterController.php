<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CounterController extends Controller
{
  public function apiCounter()
  {
    $totalDonasiSukses = DB::table('donations')->where('is_verified', 1)->sum('nominal');
    $totalCampaignComplete = DB::table('campaigns')->where('is_complete', '>', 0)->count();
    $totalCampaignProgress = DB::table('campaigns')->where([
      ['is_published', 1],
      ['is_complete', '<=', 0],
      ['max_time', '>=', Carbon::now()]
    ])->count();
    $totalUser = DB::table('users')->count();

    $output = [
      'totalDonationSuccess' => $totalDonasiSukses,
      'totalCampaignComplete' => $totalCampaignComplete,
      'totalCampaignProgress' => $totalCampaignProgress,
      'totalUser' => $totalUser
    ];

    return response()->json($output);
  }
}
