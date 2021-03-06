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

    public function userReceiver()
    {
      return $this->belongsTo('App\User','user_receiver_id','id');
    }

    public function userSender()
    {
      return $this->belongsTo('App\User','user_sender_id','id');
    }

    public function expedient()
    {
      return $this->belongsTo('App\Expedient','expedient_id','id');
    }
}
