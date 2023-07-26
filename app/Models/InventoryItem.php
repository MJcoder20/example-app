<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Pivot
{
    use HasFactory;

    public $table = "inventory_items";

    protected $fillable=['item_id','inventory_id','quantity'];

    public $timestamps=true;


}
