<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // ================= GENERAL =================
            ['name' => 'WiFi miễn phí', 'icon' => 'bx bx-wifi', 'category' => 'general'],
            ['name' => 'Bãi đỗ xe miễn phí', 'icon' => 'bx bx-parking', 'category' => 'general'],
            ['name' => 'Chỗ đỗ xe riêng', 'icon' => 'bx bx-parking', 'category' => 'general'],
            ['name' => 'Lễ tân 24 giờ', 'icon' => 'bx bx-time', 'category' => 'general'],
            ['name' => 'Bảo vệ 24/7', 'icon' => 'bx bx-shield', 'category' => 'general'],
            ['name' => 'Thang máy', 'icon' => 'bx bx-building', 'category' => 'general'],
            ['name' => 'Phòng gia đình', 'icon' => 'bx bx-home-heart', 'category' => 'general'],
            ['name' => 'Phòng không hút thuốc', 'icon' => 'bx bx-no-smoking', 'category' => 'general'],
            ['name' => 'Tiện nghi cho người khuyết tật', 'icon' => 'bx bx-wheelchair', 'category' => 'general'],
            ['name' => 'Cho phép vật nuôi', 'icon' => 'bx bx-dog', 'category' => 'general'],

            // ================= FOOD =================
            ['name' => 'Nhà hàng', 'icon' => 'bx bx-restaurant', 'category' => 'food'],
            ['name' => 'Quầy bar', 'icon' => 'bx bx-drink', 'category' => 'food'],
            ['name' => 'Bữa sáng miễn phí', 'icon' => 'bx bx-coffee', 'category' => 'food'],
            ['name' => 'Dịch vụ phòng', 'icon' => 'bx bx-dish', 'category' => 'food'],
            ['name' => 'Quán cà phê', 'icon' => 'bx bx-coffee-togo', 'category' => 'food'],
            ['name' => 'Bữa ăn cho trẻ em', 'icon' => 'bx bx-child', 'category' => 'food'],

            // ================= TRANSPORT =================
            ['name' => 'Đưa đón sân bay', 'icon' => 'bx bx-car', 'category' => 'transport'],
            ['name' => 'Đưa đón sân bay miễn phí', 'icon' => 'bx bx-car', 'category' => 'transport'],
            ['name' => 'Cho thuê xe', 'icon' => 'bx bx-car-garage', 'category' => 'transport'],
            ['name' => 'Dịch vụ taxi', 'icon' => 'bx bx-taxi', 'category' => 'transport'],
            ['name' => 'Xe đưa đón trong khu vực', 'icon' => 'bx bx-bus', 'category' => 'transport'],

            // ================= WELLNESS =================
            ['name' => 'Hồ bơi ngoài trời', 'icon' => 'bx bx-swim', 'category' => 'wellness'],
            ['name' => 'Hồ bơi trong nhà', 'icon' => 'bx bx-swim', 'category' => 'wellness'],
            ['name' => 'Spa & Massage', 'icon' => 'bx bx-spa', 'category' => 'wellness'],
            ['name' => 'Phòng gym', 'icon' => 'bx bx-dumbbell', 'category' => 'wellness'],
            ['name' => 'Phòng xông hơi', 'icon' => 'bx bx-hot', 'category' => 'wellness'],
            ['name' => 'Bồn tắm nước nóng', 'icon' => 'bx bx-bath', 'category' => 'wellness'],
            ['name' => 'Sân golf', 'icon' => 'bx bx-flag', 'category' => 'wellness'],

            // ================= ROOM =================
            ['name' => 'Máy lạnh', 'icon' => 'bx bx-wind', 'category' => 'room'],
            ['name' => 'TV màn hình phẳng', 'icon' => 'bx bx-tv', 'category' => 'room'],
            ['name' => 'Minibar', 'icon' => 'bx bx-fridge', 'category' => 'room'],
            ['name' => 'Tủ lạnh', 'icon' => 'bx bx-fridge', 'category' => 'room'],
            ['name' => 'Két an toàn', 'icon' => 'bx bx-lock', 'category' => 'room'],
            ['name' => 'Bàn làm việc', 'icon' => 'bx bx-desktop', 'category' => 'room'],
            ['name' => 'Ban công', 'icon' => 'bx bx-building-house', 'category' => 'room'],
            ['name' => 'View biển', 'icon' => 'bx bx-water', 'category' => 'room'],
            ['name' => 'View thành phố', 'icon' => 'bx bx-buildings', 'category' => 'room'],
            ['name' => 'Phòng tắm riêng', 'icon' => 'bx bx-bath', 'category' => 'room'],
            ['name' => 'Bồn tắm', 'icon' => 'bx bx-bath', 'category' => 'room'],
            ['name' => 'Vòi sen', 'icon' => 'bx bx-shower', 'category' => 'room'],

            // ================= SERVICE =================
            ['name' => 'Giặt ủi', 'icon' => 'bx bx-washer', 'category' => 'service'],
            ['name' => 'Dọn phòng hàng ngày', 'icon' => 'bx bx-home', 'category' => 'service'],
            ['name' => 'Giữ hành lý', 'icon' => 'bx bx-briefcase', 'category' => 'service'],
            ['name' => 'Dịch vụ concierge', 'icon' => 'bx bx-user', 'category' => 'service'],
            ['name' => 'Đổi tiền', 'icon' => 'bx bx-money', 'category' => 'service'],
            ['name' => 'Đặt tour', 'icon' => 'bx bx-map', 'category' => 'service'],

            // ================= BUSINESS =================
            ['name' => 'Phòng họp', 'icon' => 'bx bx-group', 'category' => 'business'],
            ['name' => 'Trung tâm business', 'icon' => 'bx bx-briefcase-alt', 'category' => 'business'],
            ['name' => 'Fax/Photocopy', 'icon' => 'bx bx-printer', 'category' => 'business'],

            // ================= ENTERTAINMENT =================
            ['name' => 'Karaoke', 'icon' => 'bx bx-music', 'category' => 'entertainment'],
            ['name' => 'Sân chơi trẻ em', 'icon' => 'bx bx-happy', 'category' => 'entertainment'],
            ['name' => 'Câu lạc bộ trẻ em', 'icon' => 'bx bx-child', 'category' => 'entertainment'],
            ['name' => 'Casino', 'icon' => 'bx bx-dice-5', 'category' => 'entertainment'],
        ];

        DB::table('amenities')->upsert(
            $data,
            ['name'], // unique key
            ['icon', 'category'] // update nếu tồn tại
        );
    }
}