<?php

declare(strict_types=1);

namespace App\Http;

use App\Dto\BinCountry;

interface BinApiClientInterface
{
    public function fetchBinCountryInformationByNumber(int $number): BinCountry;
}
