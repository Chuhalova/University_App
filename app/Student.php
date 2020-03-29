<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table='students';
    protected $fillable = ['id', 'studnumber', 'baseinfo_id_for_student'];

    public function baseinfo()
    {
        return $this->belongsTo('App\Baseinfo','baseinfo_id_for_student');
    }
}
