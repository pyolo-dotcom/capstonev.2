<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'fullname',
        'email',
        'mobile_number',
        'dob',
        'role',
        'password',
        'truck_id',
        'profile_picture',
        'driver_license_number',
        'license_expiry_date',
        'license_type',
        'otp',
        'otp_expires_at'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'otp_expires_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'license_expiry_date' => 'date',
        'dob' => 'date:Y-m-d' // Proper format for nullable dates
    ];

    protected $appends = [
        'initials',
        'profile_picture_url',
        'default_profile_picture',
        'is_license_expired',
        'formatted_license_expiry_date',
        'formatted_dob'
    ];

    /**
     * Get the user's initials from their fullname
     */
    public function getInitialsAttribute()
    {
        if (empty($this->fullname)) {
            return '';
        }

        return collect(explode(' ', $this->fullname))
            ->filter() // Remove empty values
            ->map(fn ($name) => strtoupper(substr(trim($name), 0, 1)))
            ->take(2) // Take only first two initials
            ->join('');
    }

    /**
     * Get the URL for the user's profile picture
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::disk('public')->exists($this->profile_picture)
                ? asset('storage/'.$this->profile_picture)
                : $this->default_profile_picture;
        }
        return $this->default_profile_picture;
    }

    /**
     * Get the default profile picture URL
     */
    public function getDefaultProfilePictureAttribute()
    {
        return asset('images/default-profile.svg');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return strtolower($this->role) === strtolower($role);
    }

    /**
     * Relationship to Truck model
     */
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    /**
     * Relationship to Tracking model
     */
    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'truck_id', 'truck_id');
    }

    /**
     * Check if user is a driver
     */
    public function isDriver()
    {
        return $this->role === 'driver';
    }

    /**
     * Check if license is expired
     */
    public function getIsLicenseExpiredAttribute()
    {
        return $this->license_expiry_date 
            ? $this->license_expiry_date->isPast()
            : true;
    }

    /**
     * Get formatted license expiry date
     */
    public function getFormattedLicenseExpiryDateAttribute()
    {
        return $this->license_expiry_date
            ? $this->license_expiry_date->format('F j, Y')
            : 'Not set';
    }

    /**
     * Get formatted date of birth
     */
    public function getFormattedDobAttribute()
    {
        return $this->dob
            ? $this->dob->format('F j, Y')
            : 'Not set';
    }

    /**
     * Get current location coordinates (if driver)
     */
    public function getCurrentLocationAttribute()
    {
        if (!$this->isDriver() || !$this->tracking) {
            return null;
        }

        return [
            'latitude' => $this->tracking->latitude,
            'longitude' => $this->tracking->longitude
        ];
    }

    /**
     * Get total distance traveled (if driver)
     */
    public function getTotalDistanceAttribute()
    {
        if (!$this->isDriver() || !$this->tracking) {
            return 0;
        }

        return $this->tracking->total_distance;
    }

    /**
     * Get current speed (if driver)
     */
    public function getCurrentSpeedAttribute()
    {
        if (!$this->isDriver() || !$this->tracking) {
            return 0;
        }

        return $this->tracking->speed;
    }
}