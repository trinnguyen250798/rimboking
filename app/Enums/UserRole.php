<?php

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case Customer = 2;
    case HotelOwner = 3;
    case Staff = 4;

    public function label(): string
    {
        return match ($this) {
            UserRole::Admin => 'Admin',
            UserRole::Customer => 'Customer',
            UserRole::HotelOwner => 'Hotel Owner',
            UserRole::Staff => 'Staff',
        };
    }
}
