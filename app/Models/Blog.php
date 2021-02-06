<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

  protected $fillable = [
    'admin_id',
    'title',
    'content',
    'cover_image_url',
    'slug',
    'tags',
    'is_published',
    'is_featured'
  ];

  public function author()
  {
    return $this->belongsTo(Administrator::class, 'admin_id', 'id');
  }
}
