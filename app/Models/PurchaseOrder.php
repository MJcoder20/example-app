<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','item_id','inventory_id','status'];
    protected $attributes = [
        'status' => 0,
    ];
    public $timestamps=true;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }

}
