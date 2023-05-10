<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;

class FileNotFoundException extends DomainException
{
    public function __construct(string $filename)
    {
        parent::__construct(sprintf('File "%s" does not exist.', $filename));
    }
}
