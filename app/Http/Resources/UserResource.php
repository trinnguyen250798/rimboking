<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = null;

        if ($this->avatar) {
            $base = $this->avatar;

            $images = [
                'thumb'  => url(Storage::url("$base/thumb.webp")),
                'small'  => url(Storage::url("$base/small.webp")),
                'medium' => url(Storage::url("$base/medium.webp")),
                'large'  => url(Storage::url("$base/large.webp")),
            ];
        }
        return [
            'ulid'  => $this->ulid,
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role'  => $this->role_id?->label(),
            'avatar' => $images,
            'role_id'  => $this->role_id,
            'hotel_id' => $this->when(
                $this->role_id == UserRole::Staff,
                fn() => $this->staff?->hotel?->ulid
            ),
        ];
    }
}
