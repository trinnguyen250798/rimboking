<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class District extends Model
{
    use HasUlids;
    protected $fillable = [
        'province_code',
        'code',
        'name',
        'slug'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class,'province_code','code');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class,'district_code','code');
    }
    protected static function booted()
    {
        static::creating(function ($district) {
            $district->slug = \Str::slug($district->name);
        });
    }
}