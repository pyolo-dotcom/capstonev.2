<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profit extends Model
{
    use SoftDeletes; // Gamitin ang SoftDeletes trait

    protected $fillable = [
        'date',
        'plate_number',
        'total_income',
        'total_expenses',
        'total_profit',
    ];

    protected $dates = ['deleted_at']; // Idagdag ang `deleted_at` sa dates
}