<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function stream(){
        return $this->belongsTo(ClassModel::class,'class_id');
    }

}
