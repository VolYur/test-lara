<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRatesSearchRequest;
use App\Repositories\CurrencyExchangeRatesRepository;
use Illuminate\Http\JsonResponse;

class CurrencyExchangeRatesController
{
    public function __construct(private CurrencyExchangeRatesRepository $currencyExchangeRatesRepository)
    {
    }

    public function index(CurrencyExchangeRatesSearchRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->currencyExchangeRatesRepository->all($request->getDto()),
        );
    }
}
