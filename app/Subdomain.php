<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdomain extends Model
{
    /**
     * Get the url associated with an subdomain.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
