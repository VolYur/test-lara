<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrenciesRepository
{
    public function __construct(private Currency $model)
    {
    }

    public function all(): Collection
    {
        return $this->model::all();
    }
}
