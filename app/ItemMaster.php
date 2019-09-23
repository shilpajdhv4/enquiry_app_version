<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    protected $primaryKey = "item_id";
    public $table = "tbl_item";
    public $timestamps=false;
    protected $fillable = [
        'item_name','item_rate','created_at','modify_at','is_active','item_gst'
    ];
}
