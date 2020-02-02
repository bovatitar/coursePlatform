<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function assigned(){
        return $this->hasMany("App\StudentAssignedCourse","student_id","id");
    }
}
