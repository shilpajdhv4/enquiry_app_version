<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryTemplate extends Model
{
    protected $primaryKey = "enq_temp_id";
    public $table = "enq_template";
     protected $fillable = [
        'temp_name','temp_description','enq_fields','enq_categories','user_id','loc_id','dashboard_field'
    ];
}
