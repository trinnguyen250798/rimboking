<?php

use Illuminate\Support\Str;

if (!function_exists('generateSmartSlug')) {

   function generateSmartSubdomain(string $name, ?callable $isUniqueCallback = null)
    {
        // ===== 1. Normalize =====
        $name = Str::ascii($name); // bỏ dấu tiếng Việt
        $name = strtolower($name);
        $name = preg_replace('/[^a-z0-9\s]/', ' ', $name);
        $name = preg_replace('/\s+/', ' ', trim($name));

        $words = explode(' ', $name);

        // ===== 2. Stop words (từ rác) =====
        $stopWords = [
            'hotel', 'resort', 'spa', 'and', 'the',
            'luxury', 'international', 'group',
            'japanese', 'beach', 'center', 'centre',
            'building', 'tower', 'villa', 'villas'
        ];

        // ===== 3. Location phổ biến =====
        $locations = [
            'da nang', 'ha noi', 'ha long', 'sai gon', 'ho chi minh',
            'nha trang', 'phu quoc', 'hoi an', 'vung tau', 'da lat'
        ];

        // ===== 4. Remove stop words =====
        $filtered = array_values(array_filter($words, function ($w) use ($stopWords) {
            return !in_array($w, $stopWords);
        }));

        if (empty($filtered)) {
            $filtered = $words;
        }

        // ===== 5. Detect location =====
        $locationFound = null;

        foreach ($locations as $loc) {
            $locParts = explode(' ', $loc);

            if (count(array_intersect($locParts, $filtered)) === count($locParts)) {
                $locationFound = str_replace(' ', '-', $loc);

                // remove location khỏi filtered
                $filtered = array_values(array_diff($filtered, $locParts));
                break;
            }
        }

        // ===== 6. Frequency + length scoring (detect brand) =====
        $scores = [];

        foreach ($filtered as $word) {
            $score = 0;

            // từ dài thường là brand
            $score += strlen($word);

            // từ hiếm (ít ký tự lặp) → tăng điểm
            $score += count(array_unique(str_split($word)));

            $scores[$word] = $score;
        }

        // sort theo score desc
        arsort($scores);

        $brandWords = array_keys($scores);

        // lấy tối đa 2 từ làm brand
        $brand = array_slice($brandWords, 0, 2);

        // ===== 7. Build slug =====
        $slugParts = $brand;

        if ($locationFound) {
            $slugParts[] = $locationFound;
        }

        $slug = implode('-', $slugParts);

        // fallback nếu rỗng
        if (empty($slug)) {
            $slug = implode('-', array_slice($filtered, 0, 3));
        }

        // ===== 8. Ensure unique =====
        if ($isUniqueCallback) {
            $original = $slug;
            $i = 1;

            while (!$isUniqueCallback($slug)) {
                $slug = $original . '-' . $i++;
            }
        }

        return $slug;
    }
}