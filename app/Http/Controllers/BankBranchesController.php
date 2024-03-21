<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\BankBranchesSearchRequest;
use App\Repositories\BankBranchesRepository;
use Illuminate\Http\JsonResponse;

class BankBranchesController
{
    public function __construct(private BankBranchesRepository $bankBranchesRepository)
    {
    }

    public function index(BankBranchesSearchRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->bankBranchesRepository->findAll($request->getDto())
        );
    }
}
