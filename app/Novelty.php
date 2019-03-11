<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novelty extends Model
{
    protected $fillable = ['title','public','text','expedient_id','user_id'];

    public function expedient()
    {
      return $this->belongsTo('App\Expedient');
    }
    public function user()
    {
      return $this->belongsTo('App\User','user_id','id');
    }
}
