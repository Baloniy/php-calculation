<?php

declare(strict_types=1);

use App\Dto\BinCountry;
use App\Exception\BinApiException;
use App\Http\BinApiClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use PHPUnit\Framework\Attributes\DataProvider;

class BinApiClientTest extends TestCase
{
    #[DataProvider('numberProvider')]
    public function testBinCountryInformationByNumber(int $bin, BinCountry $expected): void
    {
        $mockResponseJson = json_encode([
            'country' => [
                "alpha2" => $expected->getAlpha2(),
                "name" => $expected->getName(),
            ]
        ], JSON_THROW_ON_ERROR);

        $mockResponse = new MockResponse($mockResponseJson);

        $mockClient = new MockHttpClient($mockResponse, 'https://lookup.binlist.net/'.$bin);

        $service = new BinApiClient($mockClient);

        $country = $service->fetchBinCountryInformationByNumber($bin);

        $this->assertSame($expected->getAlpha2(), $country->getAlpha2());
    }

    public static function numberProvider(): array
    {
        return[
            [45717360, new BinCountry(name: 'Denmark', alpha2: 'DK')],
            [516793, new BinCountry(name: 'Ukraine', alpha2: 'UA')],
        ];
    }

    public function testException(): void
    {
        $this->expectException(BinApiException::class);
        $this->expectExceptionMessage('Bin API Client Error');

        $mockClient = $this->createMock(HttpClientInterface::class);

        $service = new BinApiClient($mockClient);

        $service->fetchBinCountryInformationByNumber(1);
    }
}
