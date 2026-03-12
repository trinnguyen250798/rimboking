<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\admin\hotel\HotelRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Resources\HotelResource;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $hotels = $request->user()
        ->owner()
        ->latest()
        ->paginate(10);

    return HotelResource::collection($hotels);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['owner_id'] = $request->user()->id;
        $hotel = Hotel::create($data);

        return response()->json($hotel);
    }
public function upload_thumbnail(Request $request, Hotel $hotel): JsonResponse
{
    $request->validate([
        'thumbnail' => 'required|image|max:4096'
    ]);

    $manager = new ImageManager(new Driver());
    $image = $manager->read($request->file('thumbnail'));

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
    /**
     * Display the specified resource.
     */ 
    public function show(Hotel $hotel) : HotelResource
    {
        return new HotelResource($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
