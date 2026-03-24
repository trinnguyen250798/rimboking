<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use App\Enums\TypeHotel;
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

        'status',

        'short_description',

        'rating_avg',
        'rating_count',

        'price_from',
        'price_to',

        'total_images',

        'is_refundable',
        'is_free_cancellation',
        'checkin_policy',
        'checkout_policy',

        'is_featured',
        'is_top_deal',

        'booking_count',
        'view_count',

        'type',

        'languages',
        'payment_options',

        'meta_title',
        'meta_description',

        'deleted_at',
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
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'hotel_amenities', 'hotel_id', 'amenity_id');
    }
    protected function casts(): array
    {
        return [

            'type' => TypeHotel::class,
        ];
    }

    protected static function booted()
    {
        static::creating(function ($hotel) {

            // ===== slug =====
            $baseSlug = Str::slug($hotel->name);
            $slug = $baseSlug;
            $i = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $hotel->slug = $slug;

            // // ===== subdomain =====
            // $hotel->subdomain = generateSmartSubdomain(
            //     $hotel->name,
            //     fn($s) => !self::where('subdomain', $s)->exists()
            // );
        });
    }

}
