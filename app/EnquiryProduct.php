<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryProduct extends Model
{
    protected $primaryKey = "prod_id";
    public $table = "enq_product";
     protected $fillable = [
        'prod_name','cat_id','user_id'
    ];
}
