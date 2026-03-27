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
use Symfony\Component\HttpFoundation\Response;
use App\Enums\TypeHotel;
use App\Models\Amenity;
class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request, HotelService $hotelService)
    {
        $hotels = $hotelService->user_hotel($request->user());

        return response()->json([
            'status' => true,
            'data' => HotelResource::collection($hotels)
        ],Response::HTTP_OK);
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
        ],Response::HTTP_CREATED);
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
    public function show(Hotel $hotel) : JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => new HotelResource($hotel)
        ],Response::HTTP_OK);
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
    public function getTypeHotel(): JsonResponse
    {
        $typeHotels = [];
        foreach (TypeHotel::cases() as $typeHotel) {
            $typeHotels[] = [
                'id' => $typeHotel->value,
                'name' => $typeHotel->label(),
            ];
        }
        return response()->json([
            'status' => true,
            'data' => $typeHotels,
        ],Response::HTTP_OK);
    }
    public function getAmenities(): JsonResponse{
        $data = Amenity::select('id','name', 'icon','category')->where('is_active', 1)->get()->toArray();
        return response()->json([
            'status' => true,
            'data' => $data,
        ],200);
    }
    public function getAmenitiesHotel(Request $request): JsonResponse
    {
        $hotel = Hotel::find($request->id);
        if (!$hotel) {
            return response()->json([
                'status' => false,
                'message' => 'Hotel không tồn tại',
                'data' => [],
            ], 404);
        }
        $amenities = $hotel->amenities()
            ->where('amenities.is_active', 1)
            ->select('amenities.id', 'amenities.name', 'amenities.icon')
            ->get()
            ->toArray();
        return response()->json([
            'status' => true,
            'data' => $amenities,
        ], 200);
    }
}
