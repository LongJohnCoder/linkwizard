<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlTag extends Model
{
    protected $table = 'url_tags';
    protected $fillable = array('tag');
}
