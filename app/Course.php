<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function students(){
        return $this->hasManyThrough('App\Student', 'App\StudentAssignedCourse', "course_id","id","id","student_id");
    }

    public function attendances(){
        return $this->hasMany("App\Attendance","course_id","id");
    }

    public function testTypes(){
        return $this->hasMany("App\TestType","course_id","id");
    }
}
