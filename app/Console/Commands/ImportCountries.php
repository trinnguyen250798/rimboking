<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;


class ImportCountries extends Command
{
    protected $signature = 'import:countries';
    protected $description = 'Import countries from API';

    public function handle()
    {
        $this->info('Fetching countries...');

        $viCountries = require base_path(
            'vendor/umpirsky/country-list/data/vi/country.php'
        );

        $response = Http::get(
            'https://restcountries.com/v3.1/all?fields=name,cca2,idd,currencies,flag'
        );

        $countries = $response->json();

        foreach ($countries as $item) {

            $code = $item['cca2'];

            $nameVi = $viCountries[$code] ?? $item['name']['common'];

            $currency = null;
            if(isset($item['currencies'])){
                $currency = array_key_first($item['currencies']);
            }

            Country::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $nameVi,
                    'name_en' => $item['name']['common'],

                    'phone_code' => $item['idd']['root'] ?? null,
                    'currency' => $currency,
                    'flag' => $item['flag'] ?? null,
                    'slug' => \Str::slug($nameVi)
                ]
            );
        }
        $this->info('Countries imported successfully!');
    }
}