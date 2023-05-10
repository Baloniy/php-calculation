<?php

declare(strict_types=1);

namespace App\Http;

use App\Dto\BinCountry;
use App\Exception\BinApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class BinApiClient implements BinApiClientInterface
{
    private const URL = 'https://lookup.binlist.net/';

    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

    public function fetchBinCountryInformationByNumber(int $number): BinCountry
    {
        $response = $this->httpClient->request('GET', self::URL.$number);

        if ($response->getStatusCode() !== 200) {
            throw new BinApiException();
        }

        $country = $response->toArray()['country'];

        return new BinCountry(name: $country['name'], alpha2: $country['alpha2']);
    }
}
