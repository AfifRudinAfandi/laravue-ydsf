<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}
