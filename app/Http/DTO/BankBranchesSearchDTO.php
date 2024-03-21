<?php

declare(strict_types = 1);

namespace App\Http\DTO;

class BankBranchesSearchDTO
{
    public function __construct(
        private ?string $bankSlug = null,
        private ?string $latitude = null,
        private ?string $longitude = null,
        private ?int $page = 1
    ) {}

    public function getBankSlug(): ?string
    {
        return $this->bankSlug;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }
}