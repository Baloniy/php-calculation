<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class TxtFileLoader implements FileLoader
{
    private TxtParser $txtParser;

    public function load(string $path): array
    {
        return $this->loadFile($path);
    }

    private function loadFile(string $file): array
    {
        if (!class_exists(TxtParser::class)) {
            throw new RuntimeException('Unable to load Txt file.');
        }

        $this->txtParser ??= new TxtParser();

        return $this->txtParser->parseFile($file);
    }
}
