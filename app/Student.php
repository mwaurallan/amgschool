<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{

//    use SoftDeletes;

    public function group(){
        return $this->belongsTo(StudentGroup::class,'group');
    }

}
