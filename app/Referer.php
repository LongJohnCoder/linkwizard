<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referer extends Model
{
    /**
     * Get all the urls associated with a referer.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function urls()
    {
        return $this->belongsToMany('App\Url')->withTimestamps();
    }
}
