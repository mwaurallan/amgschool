<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_items';

    public function fee(){
        return $this->belongsTo(FeeType::class,'fee_id')->withTrashed();
    }

}
