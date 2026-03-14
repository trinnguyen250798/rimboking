<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class Country extends Model
{
    use HasUlids;
    protected $fillable = [
        'name',
        'name_en',
        'code',
        'phone_code',
        'slug',
        'currency',
        'flag'
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class,'country_code','code');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class,'country_code','code');
    }
    protected static function booted()
    {
        static::creating(function ($country) {
            $country->slug = \Str::slug($country->name);
        });
    }
}