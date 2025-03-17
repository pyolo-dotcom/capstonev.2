<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelConsumption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['date', 'plate_no', 'total_km', 'avg_km_l', 'total_liters'];
}