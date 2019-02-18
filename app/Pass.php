<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{

    protected $table = 'pass';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expedient_id', 'user_receiver_id', 'user_sender_id','observation'
    ];

    public function userReceivers()
    {
      return $this->belongsTo('App\User','user_receiver_id','id');

    }


}
