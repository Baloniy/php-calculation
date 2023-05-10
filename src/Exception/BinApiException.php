<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;

class BinApiException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Bin API Client Error');
    }
}
