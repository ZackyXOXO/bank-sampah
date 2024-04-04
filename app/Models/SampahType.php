<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampahType extends Model
{
    use HasFactory;
    protected $fillable = [
        'sampah_type_name',
        'price_kg'
    ];
}
