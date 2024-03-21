<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Repositories\CurrenciesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrenciesController
{
    public function __construct(private CurrenciesRepository $currenciesRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->currenciesRepository->all(),
        );
    }
}
