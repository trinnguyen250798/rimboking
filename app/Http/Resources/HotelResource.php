<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = null;

        if ($this->thumbnail) {
            $base = $this->thumbnail;

            $images = [
                'thumb'  => url(Storage::url("$base/thumb.webp")),
                'small'  => url(Storage::url("$base/small.webp")),
                'medium' => url(Storage::url("$base/medium.webp")),
                'large'  => url(Storage::url("$base/large.webp")),
            ];
        }

        return [
            'ulid' => $this->ulid,
            'name' => $this->name,
            'slug' => $this->slug,

            'description' => $this->description,

            'address' => [
                'address' => $this->address,
                'ward' => $this->ward,
                'district' => $this->district,
                'city' => $this->city,
                'country' => $this->country,
            ],

            'location' => [
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ],

            'star_rating' => $this->star_rating,

            'checkin_time' => $this->checkin_time,
            'checkout_time' => $this->checkout_time,

            'contact' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'website' => $this->website,
            ],

            'images' => $images,

            'status' => (bool) $this->status,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}