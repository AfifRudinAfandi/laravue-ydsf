<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class CampaignProgress extends Model
{

  protected $table = 'campaign_progress';

  protected $fillable = [
    'admin_id',
    'campaign_id',
    'title',
    'content'
  ];

  public function author()
  {
    return $this->hasOne(Administrator::class, 'id', 'admin_id');
  }

  public function campaign()
  {
    return $this->belongsTo('App\Models\Campaign');
  }
}
