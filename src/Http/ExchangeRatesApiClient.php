<?php

declare(strict_types=1);

namespace App\Http;

use App\Dto\Rate;

use App\Exception\ExchangeApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ExchangeRatesApiClient implements ExchangeRatesApiClientInterface
{
    private const URL = 'https://api.exchangeratesapi.io/';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $accessKey
    ) {
    }

    public function fetchLatestRates(): array
    {
        $response = $this->httpClient->request('GET', self::URL.'latest', [
            'headers' => [
                'access_key'  => $this->accessKey
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new ExchangeApiException();
        }

        $rates = [];

        foreach ($response->toArray()['rates'] as $rate => $price) {
            $rates[$rate] = new Rate($rate, $price);
        }

        return $rates;
    }
}
