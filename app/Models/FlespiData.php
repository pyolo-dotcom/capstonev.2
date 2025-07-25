<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlespiData extends Model
{
    use HasFactory;

    protected $fillable = [
        'payload',
        'device_id',
        'latitude',
        'longitude',
        'timestamp'
    ];

    protected $casts = [
        'payload' => 'json',
        'timestamp' => 'datetime'
    ];
}