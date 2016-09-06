<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class forecast extends Model
{
    //
    protected $fillable = [
        'city_id',
        'date',
        'part',
        'temp_min',
        'temp_max',
        'temp_avg',
        'feels_like',
        'condition',
        'daytime',
        'wind_speed',
        'wind_gust',
        'wind_dir',
        'pressure_mm',
        'pressure_pa',
        'humidity',
    ];
    public function fact()
    {
        return $this->belongsTo('App\fact');
    }
}
