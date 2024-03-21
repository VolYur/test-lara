<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BanksRepository
{
    public function __construct(private Bank $model)
    {
    }

    public function findWithBranchesAndExchangeRates(string $slug): ?Bank
    {
        return $this->model::query()
            ->where('slug', $slug)
            ->with([
                'exchangeRates',
                'branches' => function ($query) {
                    $query->limit(200);
                },
                ])
            ->first();
    }

    public function all(): Collection
    {
        return $this->model::all();
    }
}
