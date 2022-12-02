<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subunit extends Model
{
    use HasFactory;
    protected $table='subunits';
    protected $fillable=[
        'subunit_name',
        'unit_parts',
        'unit_id'
    ];

    public function unit() {
        return $this->belongsTo(Unit::class,'unit_id');
    }
}
