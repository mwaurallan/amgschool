<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeStructureDetail extends Model
{
    protected $guarded = [];

    public function type(){
        return $this->belongsTo(FeeType::class,'fee_type_id');
    }
}
