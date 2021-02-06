<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
  protected $fillable = ['name', 'address', 'image'];

  public function campaigns()
  {
    return $this->hasMany('App\Models\Campaign');
  }
}
