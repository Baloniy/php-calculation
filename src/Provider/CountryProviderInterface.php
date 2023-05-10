<?php

declare(strict_types=1);

namespace App\Provider;

interface CountryProviderInterface
{
    public function getCountryEuAlpha2List(): array;
}
