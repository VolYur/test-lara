<?php

namespace App\Models;

use Database\Seeders\BanksSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    public const AVAILABLE_BANK_SLUGS = [
        'otp-bank', 'oschadbank', 'raiffeisen-bank-aval', 'ukrsibbank', 'pumb',
    ];

    protected $hidden = ['created_at', 'updated_at', ];

    public function branches(): HasMany
    {
        return $this->hasMany(BankBranch::class, 'bank_slug', 'slug');
    }

    public function exchangeRates(): HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'bank_slug', 'slug');
    }
}
