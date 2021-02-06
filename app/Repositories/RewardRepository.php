<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RewardRepository
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
      [
        'title' => 'required|min:8',
        'content' => 'required',
      ],
      [
        'required' => ':attribute harus diisi',
      ],
      [
        'title' => 'Judul',
        'content' => 'Konten',
      ]
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
      'admin_id' => $request->admin_id,
      'title' => $request->title,
      'content' => $request->content,
      'cover_image_url' => $this->nullable($request->cover_image_url),
      'video_url' => $this->nullable($request->video_url),
      'file_url' => $this->nullable($request->file_url),
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
