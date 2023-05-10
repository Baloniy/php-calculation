<?php

declare(strict_types=1);

namespace App\Http;

use App\Dto\Rate;

class FakeExchangeRatesApiClient implements ExchangeRatesApiClientInterface
{
    public function fetchLatestRates(): array
    {
        return [
            "USD" => new Rate("USD", 1.636492),
            "EUR" => new Rate("USD", 1.196476),
            "CAD" => new Rate("USD", 1.739516),
            "JPY" => new Rate("USD", 132.360679),
            "GBP" => new Rate("USD", 132.360679),
        ];
    }
}
