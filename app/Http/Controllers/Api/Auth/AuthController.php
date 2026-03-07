<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Enums\UserRole;
class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone'    => $validated['phone'] ?? null,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully.',
            'user'    => new UserResource($user),
            'token'   => $token,
        ], 201);
    }

    /**
     * Authenticate user and return a token.
     */
    public function login(LoginRequest $request, AuthService $authService): JsonResponse
    {
        $result = $authService->login(
            $request->email,
            $request->password,
            $request->remember,
            [
                UserRole::Customer->value,
            ]
        );

       if ($result['status'] == false) {
           return response()->json([
               'status' => false,
               'message' => $result['message'],
           ], 401);
       }

        return response()->json([
            'status' => true,
            'token' => $result['token'],
            'user'  => new UserResource($result['user']),
            'expires_at' => $result['expires_at']
        ], 200);
    }

    public function loginAdmin(LoginRequest $request, AuthService $authService): JsonResponse
    {
        $result = $authService->login(
            $request->email,
            $request->password,
            $request->remember,
            [
                UserRole::Admin->value,
                UserRole::Staff->value,
                UserRole::HotelOwner->value
            ]
        );

      if ($result['status'] == false) {
           return response()->json([
               'status' => false,
               'message' => $result['message'],
           ], 401);
       }

        return response()->json([
            'status' => true,
            'token' => $result['token'],
            'user'  => new UserResource($result['user']),
            'expires_at' => $result['expires_at']
        ], 200);
    }


    /**
     * Revoke the current user's token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Get the authenticated user's profile.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json(new UserResource($request->user()));
    }

    /**
     * Rotate token (revoke current, issue new).
     */
    public function refresh(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
