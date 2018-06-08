<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlLinkSchedule extends Model
{
    /**
    *  Many to one relationship with Url model
    */

    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
