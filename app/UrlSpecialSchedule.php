<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlSpecialSchedule extends Model
{

    /**
    * One to many relation with Url model
    */
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
