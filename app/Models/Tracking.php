<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'truck_id',
        'latitude',
        'longitude',
        'speed',
        'total_distance'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'total_distance' => 'float'
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'truck_id', 'truck_id')
                    ->where('role', 'driver');
    }
}