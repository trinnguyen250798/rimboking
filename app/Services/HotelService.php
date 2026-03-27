<?php

namespace App\Services;

use App\Models\Hotel;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class HotelService
{

    public function user_hotel($user)
    {
        return $user->hotels()
            ->with([
                'district:id,code,name,province_code',
                'province:id,code,name,country_code',
                'country:id,code,name',
            ])
            ->latest()
            ->paginate(10);
    }

    public function create_hotel($user, $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $amenity_ids = $data['amenity_ids'] ?? [];
            unset($data['amenity_ids']);
            $hotel = $user->hotels()->create($data);
            if (!empty($amenity_ids)) {
                $hotel->amenities()->sync($amenity_ids);
            }
            return $hotel;
        });
    }

    public function upload_thumbnail($hotel, $image)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($image);

        $basePath = "hotels/{$hotel->ulid}";

        // thumb
        $thumb = clone $image;
        Storage::disk('public')->put(
            "$basePath/thumb.webp",
            $thumb->scaleDown(width:300)->toWebp(70)
        );

        // small
        $small = clone $image;
        Storage::disk('public')->put(
            "$basePath/small.webp",
            $small->scaleDown(width:600)->toWebp(75)
        );

        // medium
        $medium = clone $image;
        Storage::disk('public')->put(
            "$basePath/medium.webp",
            $medium->scaleDown(width:900)->toWebp(80)
        );

        // large
        $large = clone $image;
        Storage::disk('public')->put(
            "$basePath/large.webp",
            $large->scaleDown(width:1600)->toWebp(85)
        );

        $hotel->update([
            'thumbnail' => $basePath
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Upload thành công',
            'data' => [
                'thumb' => url(Storage::url("$basePath/thumb.webp")),
                'small' => url(Storage::url("$basePath/small.webp")),
                'medium' => url(Storage::url("$basePath/medium.webp")),
                'large' => url(Storage::url("$basePath/large.webp"))
            ]
        ]);
    }

    public function staffs($hotel)
    {
        return $hotel->staffs()
            ->with([
                'department:id,name',
                'position:id,name',
            ])
            ->latest()
            ->paginate(25);
    }
}
