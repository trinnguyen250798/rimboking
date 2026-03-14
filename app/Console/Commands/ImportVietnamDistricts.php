<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\District;
use Illuminate\Support\Str;

class ImportVietnamDistricts extends Command
{
    protected $signature = 'import:vietnam-districts';
    protected $description = 'Import Vietnam districts';

    public function handle()
    {
        $this->info('Fetching districts...');

        $response = Http::get('https://provinces.open-api.vn/api/d/');

        if (!$response->successful()) {
            $this->error('API error');
            return;
        }

        $districts = $response->json();

        foreach ($districts as $item) {

            District::updateOrCreate(
                ['code' => $item['code']],
                [
                    'province_code' => $item['province_code'],
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'])
                ]
            );
        }

        $this->info('Districts imported successfully');
    }
}