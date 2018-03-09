<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlTagMap extends Model
{
    protected $table = 'url_tag_maps';

    public function urlTag()
    {
        return $this->hasMany('App\UrlTag','id','url_tag_id');
    }
}
