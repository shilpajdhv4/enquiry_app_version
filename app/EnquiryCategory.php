<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryCategory extends Model
{
    protected $primaryKey = "cat_id";
    public $table = "enq_category";
     protected $fillable = [
        'cat_name','cat_description','parent_cat_id','parent_cat_name','user_id','is_active'
    ];
}
