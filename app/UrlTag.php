<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlTag extends Model
{
    protected $table = 'url_tags';
    protected $fillable = array('tag');

    public function urlTagMap()
    {
        return $this->hasMany('App\UrlTagMap','url_tag_id','id');
    }
}
