<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorItem extends Pivot
{
    use HasFactory;

    public $table = "vendor_items";

    protected $fillable=['vendor_id','item_id','quantity'];

    public $timestamps=false;

}
