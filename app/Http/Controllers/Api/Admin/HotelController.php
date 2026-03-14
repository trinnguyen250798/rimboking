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
use App\Services\HotelService;
class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request, HotelService $hotelService)
    {
        $hotels = $hotelService->user_hotel($request->user());

        return HotelResource::collection($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request, HotelService $hotelService): JsonResponse
    {
        $data = $request->validated();
        $hotel = $hotelService->create_hotel($request->user(), $data);

        return response()->json([
            'status' => true,
            'message' => 'Tạo khách sạn thành công',
            'data' => $hotel
        ]);
    }
    public function upload_thumbnail(Request $request, Hotel $hotel, HotelService $hotelService): JsonResponse
    {
        $request->validate([
            'thumbnail' => 'required|image|max:4096'
        ]);
        return $hotelService->upload_thumbnail($hotel, $request->file('thumbnail'));   
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
