<?php

declare(strict_types=1);

namespace App\Exception;

class ExchangeApiException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Exchange API Client Error');
    }
}
