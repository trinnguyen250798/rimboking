<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Hotel extends Model
{
    use HasUlids;

    protected $table = 'hotels';

    protected $primaryKey = 'ulid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'description',

        'address',
        'ward',
        'district_code', 
        'province_code',
        'country_code',

        'latitude',
        'longitude',

        'star_rating',

        'checkin_time',
        'checkout_time',

        'phone',
        'email',
        'website',

        'thumbnail',

        'owner_id',

        'status'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    } 
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }   

    protected static function booted()
    {
        static::creating(function ($hotel) {
            $hotel->slug = \Str::slug($hotel->name);
        });
    }

}