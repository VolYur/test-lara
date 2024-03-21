<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Repositories\BanksRepository;
use App\Repositories\CurrenciesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BanksController
{
    public function __construct(private BanksRepository $banksRepository)
    {
    }

    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->banksRepository->all(),
        );
    }

    public function show(string $slug): JsonResponse
    {
        $bank = $this->banksRepository->findWithBranchesAndExchangeRates($slug);

        if (!$bank) {
            return new JsonResponse(
                ['error' => 'Bank not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            $bank,
        );
    }
}
