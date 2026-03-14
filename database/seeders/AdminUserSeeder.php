<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'ulid' => Str::ulid(),
                'name' => 'Admin',
                'phone' => '0900000000',
                'password' => Hash::make('12345678'),
                'role_id' => 1,
                'status' => 1,
                'email_verified_at' => now(),
                'country_id' => 1,
                'province_id' => 1,
                'district_id' => 1,
            ]
        );
    }
}