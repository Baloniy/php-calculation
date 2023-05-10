<?php

declare(strict_types=1);

require_once dirname(__DIR__).'/vendor/autoload.php';

use App\Application;
use App\Provider\CountryProvider;
use App\Http\BinApiClient;
use App\Http\FakeExchangeRatesApiClient;
use Symfony\Component\HttpClient\HttpClient;

$file = $argv[1];

if (!$file) {
    throw new RuntimeException("Please provide the file!");
}

$client = HttpClient::create();

$application = new Application(
   countryProvider: new CountryProvider(),
   exchangeRatesApiClient: new FakeExchangeRatesApiClient(),
   binApiClient: new BinApiClient($client)
);
$application->run($argv[1]);

