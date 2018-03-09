<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * An url should belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all the countries associated with an url.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country')->withTimestamps();
    }

    /**
     * Get all the platforms associated with an url.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function platforms()
    {
        return $this->belongsToMany('App\Platform')->withTimestamps();
    }

    /**
     * Get all the browsers associated with an url.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function browsers()
    {
        return $this->belongsToMany('App\Browser')->withTimestamps();
    }

    /**
     * Get the subdomain associated with an url.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subdomain()
    {
        return $this->hasOne('App\Subdomain');
    }

    public function urlSearchInfo()
    {
        return $this->hasOne('App\UrlSearchInfo');
    }

    public function urlTagMap()
    {
        return $this->hasMany('App\UrlTagMap');
    }
}
