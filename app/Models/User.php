<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'fullname',
        'email',
        'dob',
        'role',
        'password',
        'truck_id',
        'profile_picture',
        'driver_license_number', // Added driver's license number
        'license_expiry_date',   // Added license expiry date
        'license_type',          // Added license type
    ];

    protected $dates = ['deleted_at']; // Idagdag ang deleted_at sa dates

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}