<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Http\DTO\CurrencyExchangeRatesSearchDTO;
use App\Models\CurrencyExchangeRate;
use Illuminate\Database\Eloquent\Collection;

class CurrencyExchangeRatesRepository
{
    public function __construct(private CurrencyExchangeRate $model)
    {
    }

    public function all(CurrencyExchangeRatesSearchDTO $searchDTO): Collection
    {
        $query = $this->model::query();

        if ($searchDTO->getBankSlug()) {
            $query->where('bank_slug', $searchDTO->getBankSlug());
        }

        if ($searchDTO->getCode()) {
            $query->where('code', $searchDTO->getCode());
        }

        return $query->get();
    }
}
