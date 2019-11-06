<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryLocation extends Model
{
    protected $primaryKey = "loc_id";
    public $table = "enq_location";
    protected $fillable = [
        'loc_name','user_id','user_id'
    ];
}
