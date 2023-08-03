<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Pivot
{
    use HasFactory;

    public $table = 'purchase_orders';
    protected $fillable = ['user_id','item_id','inventory_id','status'];
    protected $attributes = [
        'status' => 0,
    ];
    public $timestamps=true;

   

}
