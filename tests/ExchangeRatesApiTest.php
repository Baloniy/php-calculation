<?php

declare(strict_types=1);

use App\Exception\ExchangeApiException;
use PHPUnit\Framework\TestCase;
use App\Http\ExchangeRatesApiClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRatesApiTest extends TestCase
{
    public function testFetchLatestRates(): void
    {
        $mockResponseJson = json_encode([
            'success' => true,
            'rates' => [
                "AUD" => 1.566015,
                "CAD" => 1.560132,
            ]
        ], JSON_THROW_ON_ERROR);

        $mockResponse = new MockResponse($mockResponseJson);

        $mockClient = new MockHttpClient($mockResponse, 'https://api.exchangeratesapi.io/latest');

        $service = new ExchangeRatesApiClient($mockClient, 'test-key');

        $rates = $service->fetchLatestRates();

        self::assertSame('AUD', $rates['AUD']->getName());
        self::assertSame(1.566015, $rates['AUD']->getPrice());

        self::assertSame('CAD', $rates['CAD']->getName());
        self::assertSame(1.560132, $rates['CAD']->getPrice());
    }

    public function testExceptionThrownWithUnknownBinCode(): void
    {
        $this->expectException(ExchangeApiException::class);
        $this->expectExceptionMessage('Exchange API Client Error');

        $mockClient = $this->createMock(HttpClientInterface::class);

        $service = new ExchangeRatesApiClient($mockClient, 'test-key');

        $service->fetchLatestRates();
    }
}
