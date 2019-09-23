<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerMaster extends Model
{
    protected $primaryKey = "cust_id";
    public $table = "tbl_cust_master";
    public $timestamps=false;
    protected $fillable = [
        'cust_name','mob_no','email_id','address','pincode','created_at','modify_at','is_active','city','state',
        'contact_person'
    ];
}
