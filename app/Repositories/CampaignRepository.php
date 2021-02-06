<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignRepository
{

  /**
   * Validate data from request
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return void
   */
  public function validateCampaign(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'regional_id' => 'required',
        'campaign_category_id' => 'required',
        'title' => 'required|min:8',
        'content' => 'required',
        'location' => 'required',
        'max_nominal' => 'required'
      ],
      ['required' => ':attribute harus diisi', 'min' => ':attribute minimal :min karakter'],
      [
        'regional_id' => 'Regional',
        'campaign_category_id' => 'Kategori',
        'title' => 'Judul',
        'content' => 'Konten',
        'location' => 'Lokasi',
        'max_nominal' => 'Nominal Maksimal'
      ]
    );

    if ($validator->fails())
      throw new \Exception($validator->errors(), 400);
  }

  /**
   * Validate campaign progress data from request
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return void
   */
  public function validateProgress(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'title' => 'required|min:8',
        'content' => 'required',
      ],
      ['required' => ':attribute harus diisi', 'min' => ':attribute minimal :min karakter'],
      [
        'title' => 'Judul',
        'content' => 'Konten',
      ]
    );

    if ($validator->fails())
      throw new \Exception($validator->errors(), 400);
  }

  /**
   * Change request to store campaign data
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return array
   */
  public function storeCampaign(Request $request)
  {
    $this->validateCampaign($request);
    return [
      'admin_id' => $request->admin_id,
      'regional_id' => $request->regional_id,
      'campaign_category_id' => $request->campaign_category_id,
      'title' => $request->title,
      'content' => $request->content,
      'location' => $request->location,
      'max_nominal' => $request->max_nominal,
      'max_time' => $this->nullable($request->max_time),
      'cover_image_url' => $this->nullable($request->cover_image_url),
      'video_url' => $this->nullable($request->video_url),
      'tags' => $this->nullable($request->tags),
      'slug' => Str::slug($request->title, '-') . '-' . uniqid(),
      'is_featured' => $request->is_featured,
      'is_published' => $request->is_published
    ];
  }

  /**
   * Change request to store progress data
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return array
   */
  public function storeProgress(Request $request)
  {
    $this->validateProgress($request);
    return [
      'admin_id' => $request->admin_id,
      'campaign_id' => $request->campaign_id,
      'title' => $request->title,
      'content' => $request->content,
      'video_url' => $this->nullable($request->video_url),
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
