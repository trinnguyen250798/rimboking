<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Enums\UserRole;
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
        if(!$user){
             return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy thoong tin người dùng'
            ], 404);
        }
        
        if($user->role_id == UserRole::Admin){
            app()->instance('currentHotel', $hotel);
            return $next($request);
        }else{
            if ($user->hotel_id != $hotel->id) {
                
                return response()->json([
                    'status' => false,
                    'message' => 'Bạn không có quyền truy cập khách sạn này',
               
                ], 403);
            }
        }

        

        app()->instance('currentHotel', $hotel);
        return $next($request);
    }
}