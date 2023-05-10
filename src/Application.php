<?php

declare(strict_types=1);

namespace App;

use App\Dto\Rate;
use App\Http\BinApiClientInterface;
use App\Http\ExchangeRatesApiClientInterface;
use App\Provider\CountryProviderInterface;

readonly class Application
{
    private const DISCOUNT_FIRST = 0.01;
    private const DISCOUNT_SECOND = 0.02;

    public function __construct(
        private CountryProviderInterface $countryProvider,
        private ExchangeRatesApiClientInterface $exchangeRatesApiClient,
        private BinApiClientInterface $binApiClient
    ) {
    }

    public function run(string $file): void
    {
        $rates = $this->exchangeRatesApiClient->fetchLatestRates();
        $countryEuAlpha2List = $this->countryProvider->getCountryEuAlpha2List();

        $fileContent = $this->getFileContent($file);

        $calculator = new Calculator();

        foreach ($fileContent as $row) {
            $currency = trim($row['currency']);
            $amount = trim($row['amount']);

            $country = $this->binApiClient->fetchBinCountryInformationByNumber((int)$row['bin']);

            $discount = self::DISCOUNT_SECOND;
            if (in_array($country->getAlpha2(), $countryEuAlpha2List, true)) {
                $discount = self::DISCOUNT_FIRST;
            }

            /** @var Rate $rate */
            $rate = $rates[$currency];

            $sum = $calculator->calculate($currency, (float)$amount, $rate->getPrice(), $discount);

            echo $sum. "\n";
        }
    }

    private function getFileContent(string $file): array
    {
        $loader = new TxtFileLoader();

        return $loader->load($file);
    }
}
