<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sciencework extends Model
{
    public $fillable = ['topic','type','presenting_date', 'status', 'student_id', 'teacher_id', 'cathedra_id'];
    
    public function student()
    {
        return $this->belongsTo('App\Student','student_id');
    }
}


