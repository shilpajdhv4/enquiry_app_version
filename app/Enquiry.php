<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = "enq_id";
    public $table = "enq_enquiries";
   //  public $timestamps=false;
     protected $fillable = [
        'enquiry_no','enq_mobile_no', 'enq_name', 'enq_followup_date','enq_template_id','enq_fields','enq_category' ,'enq_product' ,
		'enq_product_id' ,'enq_user_id','enq_product_name','enq_notes','follow_up' ,'created_at','is_active','insert_date','enq_emp_id','lid'
		//,'followup_date','emp_id','sync_flag','insert_date','active_inactive_status','cat_id','brand_id','cid','lid','sub_emp_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}
