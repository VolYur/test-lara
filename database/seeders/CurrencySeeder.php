<?php

namespace Database\Seeders;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CurrencySeeder extends Seeder
{
    private const AVAILABLE_CURRENCY_CODES = Currency::AVAILABLE_CURRENCY_CODES;
    private const RESOURCE_LINK = 'https://minfin.com.ua/api/currency/list?type=money&locale=uk';
    private const CURRENCY_EXCHANGE_LINK = 'https://minfin.com.ua/api/currency/rates/banks/';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedCurrencyExchangeRates();
        $this->seedCurrencies();
    }

    private function seedCurrencies()
    {
        $response = Http::get(self::RESOURCE_LINK);

        $currencies = json_decode($response->body(), true);

        $currenciesToInsert = [];

        foreach ($currencies['list'] as $currency) {
            if (in_array(mb_strtolower($currency['code']), self::AVAILABLE_CURRENCY_CODES)) {
                $res = DB::table('currency_exchange_rates')
                    ->selectRaw('AVG(bid) as avg_bid, AVG(ask) as avg_ask')
                    ->where('code', mb_strtolower($currency['code']))
                    ->first();

                $currenciesToInsert[] = [
                    'name' => Str::title($currency['name']),
                    'code' => mb_strtolower($currency['code']),
                    'avg_bid' => $res->avg_bid,
                    'avg_ask' => $res->avg_ask,
                    'actual_at' => Carbon::now(),
                ];
            }
        }

        DB::table('currencies')->insert($currenciesToInsert);
    }

    private function seedCurrencyExchangeRates()
    {
        $dataToInsert = [];//BanksSeeder::AVAILABLE_BANK_SLUGS
        foreach (self::AVAILABLE_CURRENCY_CODES as $code) {
            $response = Http::get(self::CURRENCY_EXCHANGE_LINK . $code);
            $rates = json_decode($response->body(), true);

            foreach ($rates['data'] as $rate) {
                if (in_array($rate['slug'], BanksSeeder::AVAILABLE_BANK_SLUGS)) {
                    $dataToInsert[] = [
                        'bank_slug' => $rate['slug'],
                        'code' => $code,
                        'bid' => $rate['card']['bid'] ?? $rate['cash']['bid'],
                        'ask' => $rate['card']['ask'] ?? $rate['cash']['ask'],
                        'actual_at' => $rate['card']['date'] ?? $rate['cash']['date'],
                    ];
                }
            }
        }

        DB::table('currency_exchange_rates')->insert($dataToInsert);
    }
}
