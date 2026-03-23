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
            'subdomain' => $this->subdomain,
            'description' => $this->description,
            'address' => $this->address,
            'district' => $this->district,
            'province' => $this->province,
            'country' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'star_rating' => $this->star_rating,
            'checkin_time' => $this->checkin_time,
            'checkout_time' => $this->checkout_time,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'images' => $images,
            'status' => (bool) $this->status,
            'short_description' => $this->short_description,
            'rating_avg' => $this->rating_avg,
            'rating_count' => $this->rating_count,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'total_images' => $this->total_images,
            'is_refundable' => $this->is_refundable,
            'is_free_cancellation' => $this->is_free_cancellation,
            'checkin_policy' => $this->checkin_policy,
            'checkout_policy' => $this->checkout_policy,
            'is_featured' => $this->is_featured,
            'is_top_deal' => $this->is_top_deal,
            'booking_count' => $this->booking_count,
            'view_count' => $this->view_count,
            'type' => $this->type,
            'type_label' => $this->type->label(),
            'languages' => $this->languages,
            'payment_options' => $this->payment_options,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,  
        ];
    }
}