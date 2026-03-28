<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Position extends Model
{
    protected $fillable = ['name', 'slug'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
    protected static function booted()
    {
        static::creating(function ($position) {
            // ===== slug =====
            $baseSlug = Str::slug($position->name);
            $slug = $baseSlug;
            $i = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $position->slug = $slug;
        });
    }
}
