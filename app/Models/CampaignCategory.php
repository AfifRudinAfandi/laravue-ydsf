<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model
{

  protected $table = 'campaign_category';

  protected $fillable = ['category', 'icon'];

  public function campaign()
  {
    return $this->belongsTo('App\Models\Campaign', 'campaign_category_id', 'id');
  }
}
