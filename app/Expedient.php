<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expedient extends Model
{

    protected $fillable = ['title','number','user_create_id','user_owner_id','year_id','type_id','state_id'];

    public function files(){
      return $this->hasMany('App\File');
    }

    public function user(){
      return $this->hasOne('App\User');
    }

    public function year(){
      return $this->belongsTo('App\Year');
    }

    public function passes()
    {
      return $this->hasMany('App\Pass');
    }

    public function movements()
    {
      return $this->hasMany('App\Movement');
    }

}
