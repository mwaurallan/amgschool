<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_payments';

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
