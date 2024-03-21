<?php

namespace App\Repositories\Paginators;

use Illuminate\Pagination\LengthAwarePaginator;

class BankBranchesPaginator extends LengthAwarePaginator
{
    protected $perPage = 20;

    protected $path = '/bankBranches';

    public function toArray(): array
    {
        return [
            'pagination' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'first_page_url' => $this->url(1),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
                'per_page' => $this->perPage(),
            ],
            'data' => $this->items->toArray(),
        ];
    }
}