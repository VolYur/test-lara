<?php

declare(strict_types = 1);

namespace App\Http\DTO;

class CurrencyExchangeRatesSearchDTO
{
    public function __construct(
        private ?string $bankSlug = null,
        private ?string $code = null,
    ) {}

    public function getBankSlug(): ?string
    {
        return $this->bankSlug;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }
}