<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baseinfo extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'baseinfo_id');
    }
    public function student()
    {
        return $this->belongsTo('App\Student', 'baseinfo_id_for_student');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'baseinfo_id_for_teacher');
    }
}
