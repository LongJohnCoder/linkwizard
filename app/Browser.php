<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Browser extends Model
{
    /**
     * Get all the urls associated with a browser.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function urls()
    {
        return $this->belongsToMany('App\Url')->withTimestamps();
    }
}
