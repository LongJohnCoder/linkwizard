<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkLimit extends Model
{
    /**
     * A limit should belongs to a user.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsTo('App\Url')->withTimestamps();
    }
}
