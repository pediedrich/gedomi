<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

  protected $fillable = ['observation','action','expedient_id','user_id','movement'];
  
  public function expdient()
  {
    return $this->belongsTo('App\Expedient');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
