<?php

namespace App\Enums;

enum TypeHotel: int
{
    case Hotel = 1;
    case Resort = 2;
    case Villa = 3;
    case Homestay = 4;

    public function label(): string
    {
        return match ($this) {
            TypeHotel::Hotel => 'Khách sạn',
            TypeHotel::Resort => 'Resort',
            TypeHotel::Villa => 'Biệt thự',
            TypeHotel::Homestay => 'Homestay',
        };
    }
}
