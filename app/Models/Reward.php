<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{

  protected $fillable = [
    'admin_id',
    'title',
    'cover_image_url',
    'description',
    'file_url',
    'is_published',
  ];

  public function author()
  {
    return $this->belongsTo(Administrator::class, 'admin_id', 'id');
  }
}
