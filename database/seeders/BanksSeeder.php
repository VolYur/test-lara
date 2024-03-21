<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BanksSeeder extends Seeder
{
    public const AVAILABLE_BANK_SLUGS = Bank::AVAILABLE_BANK_SLUGS;
    private const RESOURCE_LINK = 'https://finance.ua/banks/api/organizationsList?locale=uk';
    private const RESOURCE_LINK_FOR_BRANCHES = 'https://finance.ua/api/organization/v1/branches?locale=uk';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedBanks();
        $this->seedBankBranches();
    }

    private function seedBanks()
    {
        $response = Http::get(self::RESOURCE_LINK);

        $banks = json_decode($response->body(), true);

        $dataToInsert = [];

        foreach ($banks['responseData'] as $bank) {
            if (in_array(mb_strtolower($bank['slug']), self::AVAILABLE_BANK_SLUGS)) {
                $dataToInsert[] = [
                    'name' => Str::title($bank['title']),
                    'slug' => $bank['slug'],
                    'description' => $bank['longTitle'],
                    'logo' => $bank['logo'][0],
                    'website' => $bank['site'],
                    'phone_number' => $bank['phone'],
                    'email' => $bank['email'],
                    'address' => $bank['legalAddress'],
                    'rating' => $bank['ratingBank'],
                ];
            }
        }

        DB::table('banks')->insert($dataToInsert);
    }

    private function seedBankBranches()
    {
        $dataToInsert = [];

        foreach (self::AVAILABLE_BANK_SLUGS as $slug) {
            $response = Http::get(self::RESOURCE_LINK_FOR_BRANCHES . '&slug=' . $slug);
            $branchGroups = json_decode($response->body(), true);

            foreach ($branchGroups['data'] as $branches) {
                foreach ($branches['data'] as $branch) {
                    $dataToInsert[] = [
                        'bank_slug' => $slug,
                        'name' => $branch['branch_name'],
                        'address' => $branch['address'],
                        'phone_number' => $branch['phone'],
                        'latitude' => $branch['lat'],
                        'longitude' => $branch['lng'],
                    ];
                }
            }
        }

        DB::table('bank_branches')->insert($dataToInsert);
    }
}
