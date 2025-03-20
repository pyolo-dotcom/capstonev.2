<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $fillable = ['truck_id', 'latitude', 'longitude', 'speed', 'total_distance'];
}
