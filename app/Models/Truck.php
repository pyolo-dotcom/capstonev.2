<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cr_number',
        'date',
        'mv_file_number',
        'plate_number',
        'engine_number',
        'chassis_number',
        'denomination',
        'piston_displacement',
        'number_of_cylinders',
        'fuel',
        'make',
        'series',
        'body_type',
        'body_number',
        'year_model',
        'gross_weight',
        'net_weight',
        'shipping_weight',
        'net_capacity',
        'owner_name',
        'address'
    ];

    protected $dates = ['date', 'deleted_at'];

    protected $casts = [
        'date' => 'date:Y-m-d'
    ];
}