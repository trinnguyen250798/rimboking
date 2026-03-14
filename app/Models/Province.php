<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class Province extends Model
{
    use HasUlids;
    protected $fillable = [
        'country_code',
        'name',
        'slug',
        'code'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_code','code');
    }

    public function districts()
    {
        return $this->hasMany(District::class,'province_code','code');
    }
    public function hotels()
    {
        return $this->hasMany(Hotel::class,'province_code','code');
    }
    protected static function booted()
    {
        static::creating(function ($province) {
            $province->slug = \Str::slug($province->name);
        });
    }
}
