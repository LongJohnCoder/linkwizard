<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlFeature extends Model
{
  /**
   * Get the url associated with an url_feature.
   *
   * @return Illuminate\Database\Eloquent\Relations\belongsTo
   */
  public function url()
  {
      return $this->belongsTo('App\Url');
  }
}
