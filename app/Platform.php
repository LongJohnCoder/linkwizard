<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * Get all the urls associated with a platform.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function urls()
    {
        return $this->belongsToMany('App\Url')->withTimestamps();
    }
}
