<?php

namespace App\Http;

interface ExchangeRatesApiClientInterface
{
    public function fetchLatestRates(): array;
}
