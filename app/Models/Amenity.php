<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'category',
        'is_active',
        'order_index',
    ];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenities', 'amenity_id', 'hotel_id');
    }
}
