<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = [
        'plate_no', 'eir_no', 'container_van_no', 'size', 
        'shipper_consignee', 'voyage_vessel','voyage_no', 'pickup_location', 
        'delivery_location', 'status'
    ];
}