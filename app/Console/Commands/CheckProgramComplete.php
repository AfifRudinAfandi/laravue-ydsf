<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Console\Command;

class CheckProgramComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check complete program';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campaigns = Campaign::where([
            ['is_published', '>', 0],
            ['is_complete', '<=', 0]
        ])->whereHas('donations')->select(['id', 'max_nominal'])->get();

        foreach ($campaigns as $campaign) {
            $total = (int)Donation::where('campaign_id', $campaign->id)->sum('nominal');
            $max_nominal = (int)$campaign->max_nominal;

            if ($max_nominal === $total) {
                Campaign::where('id', $campaign->id)->update(['is_complete' => 1]);
            }
        }
    }
}
