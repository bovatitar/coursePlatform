<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function type(){
        return $this->hasOne("App\TestType","id","test_type_id");
    }
}
