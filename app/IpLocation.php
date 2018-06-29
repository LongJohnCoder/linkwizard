<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpLocation extends Model
{
    /**
     * One to many relation with Url model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
