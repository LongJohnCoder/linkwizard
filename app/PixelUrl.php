<?php

namespace App;
use App\PixelProviders;
use App\Url;

use Illuminate\Database\Eloquent\Model;

class PixelUrl extends Model
{
    public function pixelProviders() {
        return $this->belongsTo("App\PixelProviders"); 
    }
    public function urlPixel() {
        return $this->belongsTo("App\Url"); 
    }
}
