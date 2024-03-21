<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Jobs\UpdateCurrenciesJob;
use App\Models\Bank;
use App\Models\Currency;
use Database\Seeders\BanksSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateCurrencies extends Command
{
    private const CURRENCY_EXCHANGE_LINK = 'https://minfin.com.ua/api/currency/rates/banks/';

    protected $signature = 'app:update-currencies';

    protected $description = 'Command description';

    public function handle(): void
    {
        $dataToInsert = [];
        foreach (Currency::AVAILABLE_CURRENCY_CODES as $code) {
            $rates = $this->getCurrencyExchangeRates($code);
            foreach ($rates as $rate) {
                if (in_array($rate['slug'], Bank::AVAILABLE_BANK_SLUGS)) {
                    $res = DB::table('currency_exchange_rates')
                        ->where(['bank_slug' => $rate['slug'], 'code' => $code])
                        ->update(
                            [
                                'bid' => $rate['card']['bid'] ?? $rate['cash']['bid'],
                                'ask' => $rate['card']['ask'] ?? $rate['cash']['ask'],
                                'actual_at' => $rate['card']['date'] ?? $rate['cash']['date'],
                            ]
                        );

                    if (!$res) {
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

        }
        DB::table('currency_exchange_rates')->insert($dataToInsert);
    }

    private function getCurrencyExchangeRates(string $code): array
    {
        $response = Http::get(self::CURRENCY_EXCHANGE_LINK . $code);
        return json_decode($response->body(), true)['data'] ?? [];
    }
}
