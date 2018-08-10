<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Url;
use App\UserPixels;

class UserPixels extends Model
{
    /**
     * An pixel should belongs to a url.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsToMany('App\Url');
    }

    /**
     * An pixel should belongs to a pixelProvider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pixelProvider()
    {
        return $this->belongsTo('App\PixelProviders');
    }
}
