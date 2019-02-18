<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeFile extends Model
{
    public function files()
    {
      return $this->hasMany('App\File');
    }
}
