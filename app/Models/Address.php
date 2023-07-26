<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['addressable_id','addressable_type','city_id','district','street','phone'];

    public $timestamps = true;
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

}
