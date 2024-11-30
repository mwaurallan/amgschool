<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $guarded = [];


    public function c(){
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
