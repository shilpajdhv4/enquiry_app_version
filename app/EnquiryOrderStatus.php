<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryOrderStatus extends Model
{
    protected $primaryKey = "or_id";
    public $table = "enq_order_status";
    protected $fillable = [
        'or_status_name','user_id'
    ];
}
