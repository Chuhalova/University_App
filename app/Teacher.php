<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function baseinfo()
    {
        return $this->hasOne('App\Baseinfo','id');
    }
}
