<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use Illuminate\Support\Str;

class ImportVietnamProvinces extends Command
{
    protected $signature = 'import:vietnam-provinces';
    protected $description = 'Import Vietnam provinces';

    public function handle()
    {
        $this->info('Fetching provinces...');

        $response = Http::get('https://provinces.open-api.vn/api/p/');

        if (!$response->successful()) {
            $this->error('API error');
            return;
        }

        $provinces = $response->json();

        foreach ($provinces as $item) {

            Province::updateOrCreate(
                ['code' => $item['code']],
                [
                    'country_code' => 'VN',
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'])
                ]
            );
        }

        $this->info('Provinces imported successfully');
    }
}