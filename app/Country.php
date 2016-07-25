<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * Get all the urls associated with a country.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function urls()
    {
        return $this->belongsToMany('App\Url')->withTimestamps();
    }
}
