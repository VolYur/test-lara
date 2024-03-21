<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Http\DTO\BankBranchesSearchDTO;
use App\Http\DTO\CurrencyExchangeRatesSearchDTO;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class CurrencyExchangeRatesSearchRequest extends Request
{
    public function getDto(): CurrencyExchangeRatesSearchDTO
    {
        return new CurrencyExchangeRatesSearchDTO(
            $_GET['bank_slug'] ?? null,
            $_GET['code'] ?? null,
        );
    }
}