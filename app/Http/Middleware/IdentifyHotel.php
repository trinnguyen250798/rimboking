<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Hotel;

class IdentifyHotel
{
   public function handle(Request $request, Closure $next)
    {
        // Lấy ULID hotel từ header X-Hotel-KEY
        $hotelKey = $request->header('X-Hotel-KEY');

        if (!$hotelKey) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu X-Hotel-KEY'
            ], 400);
        }

        // Tìm hotel theo ULID
        $hotel = Hotel::where('ulid', $hotelKey)->first();

        if (!$hotel) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy khách sạn'
            ], 404);
        }

        $user = Auth::user();
        if ($user->hotel_id != $hotel->id) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập khách sạn này'
            ], 403);
        }

        app()->instance('currentHotel', $hotel);

        return $next($request);
    }
}