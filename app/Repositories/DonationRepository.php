<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonationRepository
{

  /**
   * Validate data from request
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return void
   */
  public function validateRequest(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      ['alias' => 'required'],
      ['nominal' => 'required'],
      ['fake_nominal' => 'required']
    );

    if ($validator->fails())
      throw new \Exception($validator->errors(), 400);
  }

  /**
   * Change request to store donation data
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return array
   */
  public function storeRequest(Request $request)
  {
    $this->validateRequest($request);
    return [
      'user_id' => $request->user_id,
      'admin_id' => $request->admin_id,
      'campaign_id' => $request->campaign_id,
      'alias' => $request->alias,
      'nominal' => $request->nominal,
      'message' => $this->nullable($request->message) ?? '',
      'is_verified' => $request->is_verified ?? 0,
    ];
  }

  /**
   * Set null for data if empty
   * 
   * @param mixed $data
   * 
   * @return mixed
   */
  public function nullable($data)
  {
    if (empty($data))
      return null;

    return $data;
  }
}
