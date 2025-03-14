<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips'; // Ensure this matches your database table name

    protected $fillable = ['plate_no', 'trip_type', 'num_trips'];

}
