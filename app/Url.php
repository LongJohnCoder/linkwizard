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
    protected $table = 'urls';
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

    // public function urlTag()
    // {
    //     return $this->hasManyThrough('\App\UrlTag',
    //           '\App\UrlTagMap',
    //           'url_id',
    //           '')
    // }

    // public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    // {
    //     $model = new $related;
    //     $table = $model->getTable();
    //     $throughModel = new $through;
    //     $pivot = $throughModel->getTable();
    //
    //     return $model
    //         ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
    //         ->select($table . '.*')
    //         ->where($pivot . '.' . $firstKey, '=', $this->id);
    // }

    public function thisHasManyThrough($finalModel, $throughModel, $baseKey='id', $throughToBaseKey='url_id', $throughToFinalKey='url_tag_id', $finalKey='id', $rows = null)
    {
        $base         = 'urls';
        $rowsToSelectFromBase = '';
        if($rows != null && count($rows) > 0) {
          foreach ($rows as $key => $colName) {
            if($rowsToSelectFromBase != '') {
              $rowsToSelectFromBase .= ','.$base.'.'.$colName;
            } else {
              $rowsToSelectFromBase .= $base.'.'.$colName;
            }
          }
        } else {
          $rowsToSelectFromBase .= $base.'*';
        }

        $final        = new $finalModel;
        $final        = $final->getTable();
        $through      = new $throughModel;
        $through      = $through->getTable();

        dd($this->join($through, $base.'.'.$baseKey, '=', $through.'.'.$throughToBaseKey)
                      ->join($final,  $through.'.'.$throughToFinalKey, '=', $final.'.'.$finalKey)->toSql());
                      //->select($rowsToSelectFromBase);
    }

    public function urlTag()
    {
        return $this->thisHasManyThrough('\App\UrlTag', '\App\UrlTagMap');
    }


    /**
    * One to one relation with UrlFeature model
    */
    public function urlFeature()
    {
        return $this->hasOne('App\UrlFeature', 'url_id');
    }

    /**
    * One to many relation with UrlSpecialSchedule model
    */
    public function urlSpecialSchedules()
    {
        return $this->hasMany('App\UrlSpecialSchedule', 'url_id');
    }

    /**
    * One to many relation with CircularLink model
    */
    public function circularLink()
    {
        return $this->hasMany('App\CircularLink', 'url_id');
    }

/**

* One to many relationship with UrlLinkSchedule model
*/
public function url_link_schedules()
{
    return $this->hasMany('App\UrlLinkSchedule', 'url_id');
}

public function getGeoLocation()
{
    return $this->hasMany('App\Geolocation', 'url_id');
}

}
