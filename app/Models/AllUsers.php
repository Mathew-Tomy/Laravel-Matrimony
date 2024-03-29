<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllUsers extends Model
{
  use SoftDeletes;

  protected $guarded = [];


  public function user()
  {
      return $this->belongsTo(User::class)->withTrashed();
  }

}
