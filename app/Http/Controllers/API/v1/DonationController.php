<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\PaymentLog;
use App\Repositories\DonationRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\VA;
use Carbon\Carbon;

class DonationController extends Controller
{
  protected $model;
  protected $donationRepo;
  protected $relationCol;

  public function __construct(Donation $donation, DonationRepository $donationRepo)
  {
    $this->model = new Repository($donation);
    $this->donationRepo = $donationRepo;
    $this->relationCol = ['campaign:id,title,slug,cover_image_url', 'user:id,name', 'admin:id,name'];
  }

  /**
   * Get all donation
   * 
   * @return json
   */
  public function getAllDonation()
  {
    return $this->model->getAll($this->relationCol);
  }

  /**
   * Get specific donation by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getDonationById($id)
  {
    return $this->model->getById($id, $this->relationCol);
  }

  /**
   * Get all donation by campaign ID
   * 
   * @return json
   */
  public function getByCampaignId($campaign_id)
  {
    return $this->model->getByColumns([['campaign_id', $campaign_id], ['is_verified', '>=', 1]], $this->relationCol, 'created_at', 'DESC', 5);
  }

  /**
   * Get limited donation by user ID
   * 
   * @return json
   */
  public function getByUserId($user_id)
  {
    return $this->model->getByColumns([
      ['user_id', $user_id],
    ], $this->relationCol, 'created_at', 'DESC', 3);
  }

  /**
   * Get all donation by user ID
   * 
   * @return json
   */
  public function getByUserIdReport($user_id)
  {
    return $this->model->getByColumns([
      ['user_id', $user_id],
    ], $this->relationCol, 'created_at', 'DESC');
  }

  /**
   * Create donation
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function create(Request $request)
  {
    $reqData = $this->donationRepo->storeRequest($request);

    //TODO: add id into random number
    $bill_id = mt_rand();

    $va = new VA();
    $createVa = $va->createVA($bill_id, $reqData['nominal'], $reqData['alias']);

    if (isset($createVa['error']) && $createVa['error'] !== '') {
      return json_encode($createVa);
    }

    $data = array_merge($reqData, ['va' => $createVa['virtual_account'], 'trx_id' => $createVa['trx_id']]);
    $create = $this->model->create($data);

    // Create notification
    if ($create) {
      $campaign = Campaign::where('id', $reqData['campaign_id'])->select('title')->first();

      $notif = new Notification();
      $notif->user_id = $reqData['user_id'];
      $notif->title = '[Donasi] Lanjutkan Pembayaran';
      $notif->body = 'Segera lakukan pembayaran untuk donasi <strong>"' . $campaign->title . '"</strong> sebesar <strong>Rp. ' . number_format((int)$reqData['nominal'], 2, ',', '.') . '</strong> dengan kode pembayaran Virtual Account BNI: <strong>' . $createVa['virtual_account'] . '</strong> sebelum ' . Carbon::now()->addDay(1)->format('h:i:s d-m-Y') . '.';
      $notif->type = 'create-payment';
      $notif->save();

      $log = new PaymentLog();
      $log->user_id = $reqData['user_id'];
      $log->campaign_id = $reqData['campaign_id'];
      $log->c_name = $reqData['alias'];
      $log->trx_amount = $reqData['nominal'];
      $log->trx_id = $createVa['trx_id'];
      $log->virtual_account = $createVa['virtual_account'];
      $log->save();
    }


    return $create;
  }

  /**
   * Check every donations payment
   */
  public function checkPayment()
  {
  }

  /**
   * Update campaign message
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function update(Request $request, $id)
  {
    return $this->model->updateById($id, [
      'nominal' => $request->nominal,
      'message' => $request->message,
      'is_verified' => $request->is_verified,
    ]);
  }

  /**
   * Verif donation
   * 
   * @param int $id
   * 
   * @return json
   */
  public function verification($uuid)
  {
    return $this->model->updateByColumns(['transaction_uuid' => $uuid], ['is_verified' => 1]);
  }

  /**
   * Delete specific donations by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function delete($id)
  {
    return $this->model->deleteById($id);
  }

  /**
   * Bulk delete by IDs
   * 
   * @return json
   */
  public function bulkDelete(Request $request)
  {
    return $this->model->bulkDelete($request->ids);
  }
}
