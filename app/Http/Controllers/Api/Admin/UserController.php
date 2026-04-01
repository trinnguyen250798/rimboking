<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Hotel;
use App\Models\User;
use App\Services\HotelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Response;
class UserController extends Controller
{
    /**
     * List all users (paginated).
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::latest()->paginate(15);

        return response()->json([
            'status' => true,
            'data' => UserResource::collection($users)
        ],Response::HTTP_OK);
    }

    /**
     * Store a new user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role_id'  => ['nullable', 'integer'],
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status' => true,
            'data' => new UserResource($user)
        ],Response::HTTP_CREATED);
    }

    /**
     * Show a single user.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => new UserResource($user)
        ],Response::HTTP_OK);
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'email'    => ['sometimes', 'email', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', Password::defaults()],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role_id'  => ['nullable', 'integer'],
            'status'   => ['nullable', 'integer'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'status' => true,
            'data' => new UserResource($user)
        ],Response::HTTP_OK);
    }

    /**
     * Soft-delete a user.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa tài khoản thành công.'
        ],Response::HTTP_NO_CONTENT);
    }

    public function upload_avatar(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|max:4096'
        ]);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));

        $basePath = "users/{$user->ulid}";

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

        $user->update([
            'avatar' => $basePath
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
}
