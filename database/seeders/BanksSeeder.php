<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $response = Http::get('https://minfin.com.ua/api/currency/list?type=money&locale=uk');

        json_decode($response->body());

    }
}
