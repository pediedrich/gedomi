<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //

    public function expedients(){
      return $this->hasMany('App\Expedient');
    }
}
