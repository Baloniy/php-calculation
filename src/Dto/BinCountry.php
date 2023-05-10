<?php

declare(strict_types=1);

namespace App\Dto;

readonly class BinCountry
{
    public function __construct(
        private string $name,
        private string $alpha2,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlpha2(): string
    {
        return $this->alpha2;
    }
}
