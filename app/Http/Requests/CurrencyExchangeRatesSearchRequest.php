<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Http\DTO\BankBranchesSearchDTO;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class BankBranchesSearchRequest extends Request
{
    public function getDto(): BankBranchesSearchDTO
    {
        return new BankBranchesSearchDTO(
            $_GET['bank_slug'] ?? null,
            $_GET['latitude'] ?? null,
            $_GET['longitude'] ?? null,
                (int) ($_GET['page'] ?? null),
        );
    }
}