<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlSearchInfo extends Model
{
    protected $table    = 'url_search_info';
    protected $fillable = array('description','url_id');
}
