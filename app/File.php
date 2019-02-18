<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
      public function typeFile()
      {
        return $this->belongsTo('App\typeFile','type_id','id');
      }
}
