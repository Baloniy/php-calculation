<?php

declare(strict_types=1);

namespace App;

interface FileLoader
{
    public function load(string $path): mixed;
}
