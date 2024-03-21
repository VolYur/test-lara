<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CurrencySeeder extends Seeder
{
    private const AVAILABLE_CURRENCY_CODES = [
        'pln', 'chf', 'gbp', 'eur', 'usd',
    ];

    private const RESOURCE_LINK = 'https://minfin.com.ua/api/currency/list?type=money&locale=uk';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $response = Http::get(self::RESOURCE_LINK);

        $currencies = json_decode($response->body(), true);

        $currenciesToInsert = [];

        foreach ($currencies['list'] as $currency) {
            if (in_array(mb_strtolower($currency['code']), self::AVAILABLE_CURRENCY_CODES)) {
                $currenciesToInsert[] = [
                    'name' => Str::title($currency['name']),
                    'code' => mb_strtolower($currency['code']),
                ];
            }
        }

        DB::table('currencies')->insert($currenciesToInsert);
    }
}
