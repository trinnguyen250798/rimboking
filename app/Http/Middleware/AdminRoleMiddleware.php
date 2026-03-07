<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserRole;

class AdminRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ],401);
        }

        $allowedRoles = [
            UserRole::Admin->value,
            UserRole::HotelOwner->value,
            UserRole::Staff->value,
        ];

        if (!in_array($user->role_id, $allowedRoles)) {
            return response()->json([
                'message' => 'Permission denied'
            ],403);
        }

        return $next($request);
    }
}