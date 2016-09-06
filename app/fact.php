<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fact extends Model
{
    //
    public function forecasts(){
        return $this->hasMany('App\forecast');
    }
}
