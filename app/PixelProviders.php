<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPixels;
use App\PixelUrl;

class PixelProviders extends Model
{
    /**
     * One to many relationship with UserPixel table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pixels(){
        return $this->hasMany('App\UserPixels');
    }
    /**
     * One to many relationship with UserPixel table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pixelUrl(){
        return $this->hasMany('App\PixelUrl');
    }
    
}
