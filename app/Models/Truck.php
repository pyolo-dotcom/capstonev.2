<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Truck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image_path',  // Make sure this exists
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
    protected $appends = ['image_url'];

    // Accessor for easy image URL retrieval
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/default-truck.png');
        }

        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        return Storage::url($this->image_path);
    }

    // Delete the physical image file
    public function deleteImageFile()
    {
        if ($this->image_path && Storage::exists($this->image_path)) {
            Storage::delete($this->image_path);
        }
    }
}