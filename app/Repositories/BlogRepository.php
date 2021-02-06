<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogRepository
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
        'is_published' => 'required',
        'is_featured' => 'required'
      ],
      [
        'required' => ':attribute harus diisi',
        'min' => ':attribute minimal :min karakter'
      ],
      [
        'title' => 'Judul',
        'content' => 'Konten',
        'is_published' => 'Publish',
        'is_featured' => 'Featured'
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
      'slug' => Str::slug($request->title, '-') . '-' . uniqid(),
      'tags' => $this->nullable($request->tags),
      'is_published' => $request->is_published,
      'is_featured' => $request->is_featured
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
