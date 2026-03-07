<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($email, $password, $remember = false , $role = [2])
    {
         $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'Email không tồn tại'
            ];
        }

        if ( !Hash::check($password, $user->password)) {
            return [
                'status' => false,
               'message' => 'Mật khẩu không chính xác'
            ];
        }

    
        if (!in_array($user->role_id->value, $role)) {
            return [
                'status' => false,
                'message' => 'Tài khoản không có quyền truy cập',
            ];
        }
        $user->tokens()->delete();
        $expiresAt = $remember ? now()->addDays(30) : now()->addDay();
        $token = $user->createToken('api-token', ['*'], $expiresAt)->plainTextToken;

        return [
            'status' => true,
            'user'       => $user,
            'token'      => $token,
            'expires_at' => $expiresAt
        ];
    }

}