<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=[
        'product_name',
        'unit_id',
        'subunit_id',
        'quantity',
    ];

    public function unit() {
        return $this->belongsTo(Unit::class,'unit_id');
    }
}
