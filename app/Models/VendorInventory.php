<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorInventory extends Pivot
{
    use HasFactory;

    public $table = "vendor_inventories";

    protected $fillable=['vendor_id','inventory_id'];

    public $timestamps=false;

}
