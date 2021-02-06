<?php

namespace App\Console\Commands;

use App\Mail\PaymentSuccess;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\PaymentLog;
use App\VA;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Payment from Bank API';

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
        $donationNotVerified = Donation::where([
            ['is_verified', 0],
            ['expired_payment_at', '>', Carbon::now()]
        ])->get();

        foreach ($donationNotVerified as $donation) {
            $trx_id = $donation->trx_id ?? 0;

            if ($trx_id != 0) {
                $checkPayment = new VA();
                $status = $checkPayment->checkBill($trx_id);

                if (isset($status['payment_amount']) && (int)$status['payment_amount'] === (int)$donation->nominal) {
                    $updateStatus = Donation::where('trx_id', $trx_id)->update(['is_verified' => 1]);

                    if ($updateStatus) {
                        $notif = new Notification();
                        $notif->user_id = $donation->user->id;
                        $notif->title = '[Pembayaran] Berhasil Melakukan Pembayaran';
                        $notif->body = 'Berhasil melakukan pembayaran untuk donasi: <strong>"' . $donation->campaign->title . '"</strong> sebesar <strong>Rp. ' . number_format((int)$status['trx_amount'], 2, ',', '.') . '</strong> pada ' . $status['datetime_payment'] . '.';
                        $notif->type = 'payment-success';
                        $notif->save();

                        PaymentLog::where('trx_id', $trx_id)->update([
                            'payment_amount' => $status['payment_amount'],
                            'billing_type' => $status['billing_type'],
                            'payment_at' => $status['datetime_payment']
                        ]);

                        $uid = $donation->user->email ?? 0;
                        $this->sendNotif($uid);
                    }
                }
            }
        }
    }

    /**
     * Send notification to email or sms
     */
    public function sendNotif($uid)
    {
        if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {
            Mail::to($uid)->send(new PaymentSuccess());
        } else {
            $this->info('Send SMS');
        }
    }
}
