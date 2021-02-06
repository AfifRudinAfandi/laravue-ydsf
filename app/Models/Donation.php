<?php

namespace App\Models;

use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

class Donation extends Model
{

  protected $fillable = [
    'user_id', 'admin_id', 'campaign_id', 'alias', 'nominal', 'fake_nominal', 'message', 'is_verified', 'va', 'trx_id', 'is_read',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      try {
        $model->transaction_uuid = Uuid::uuid4()->toString();
        $model->expired_payment_at = Carbon::now()->addDay(1);
      } catch (UnsatisfiedDependencyException $e) {
        abort(500, $e->getMessage());
      }
    });
  }

  public function user()
  {
    return $this->hasOne('App\Models\User', 'id', 'user_id');
  }

  public function admin()
  {
    return $this->hasOne(Administrator::class, 'id', 'admin_id');
  }

  public function campaign()
  {
    return $this->belongsTo('App\Models\Campaign');
  }
}
