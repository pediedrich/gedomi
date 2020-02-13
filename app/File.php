<?php

namespace App;
use App\FullTextSearch;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    use FullTextSearch;
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'title',
        'abstract'
    ];


    public function typeFile()
    {
      return $this->belongsTo('App\typeFile','type_id','id');
    }
}
