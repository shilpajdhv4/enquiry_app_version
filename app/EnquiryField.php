<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryField extends Model
{
    protected $primaryKey = "f_id";
    public $table = "enq_fields";
     protected $fillable = [
        'enq_fields_val','u_id'
    ];
}
