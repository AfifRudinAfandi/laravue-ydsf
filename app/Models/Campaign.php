<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;

class Campaign extends Model
{

  protected $fillable = [
    'admin_id',
    'regional_id',
    'campaign_category_id',
    'title',
    'content',
    'location',
    'max_nominal',
    'max_time',
    'cover_image_url',
    'video_url',
    'tags',
    'slug',
    'is_published',
    'is_featured',
    'is_complete'
  ];

  public function admin()
  {
    return $this->belongsTo(Administrator::class, 'admin_id', 'id');
  }

  public function donations()
  {
    return $this->hasMany('App\Models\Donation', 'campaign_id', 'id');
  }

  public function regional()
  {
    return $this->hasOne('App\Models\Regional', 'id', 'regional_id');
  }

  public function category()
  {
    return $this->hasOne('App\Models\CampaignCategory', 'id', 'campaign_category_id');
  }

  public function progress()
  {
    return $this->hasMany('App\Models\CampaignProgress', 'campaign_id', 'id');
  }
}
