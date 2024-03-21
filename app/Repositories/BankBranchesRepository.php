<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Http\DTO\BankBranchesSearchDTO;
use App\Models\BankBranch;
use App\Models\Currency;
use App\Repositories\Paginators\BankBranchesPaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class BankBranchesRepository
{
    private const PER_PAGE = 20;

    public function __construct(private BankBranch $model)
    {
    }

    public function findAll(BankBranchesSearchDTO $bankBranchesSearchDTO): BankBranchesPaginator
    {
        $query = $this->buildQuery($bankBranchesSearchDTO);
        $queryForTotal = clone $query;

        return new BankBranchesPaginator(
            $query->limit(self::PER_PAGE)->forPage($bankBranchesSearchDTO->getPage())->get(),
            $queryForTotal->count(),
            self::PER_PAGE
        );
    }

    private function buildQuery(BankBranchesSearchDTO $bankBranchesSearchDTO): Builder
    {
        $query = $this->model::query();

        if ($bankBranchesSearchDTO->getBankSlug()) {
            $query->where('bank_slug', $bankBranchesSearchDTO->getBankSlug());
        }

        if ($bankBranchesSearchDTO->getLatitude() && $bankBranchesSearchDTO->getLongitude()) {
            //also geometry and spatials indexes could be used to enchance the query
            $query->selectRaw(
                '*, (6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance',
                [
                    $bankBranchesSearchDTO->getLatitude(),
                    $bankBranchesSearchDTO->getLongitude(),
                    $bankBranchesSearchDTO->getLatitude(),
                ]
            )->orderBy('distance');
        }

        return $query;
    }


}
