<?php

namespace App;

use App\Exception\FileNotFoundException;

class TxtParser
{
    public function parseFile(string $filename): array
    {
        if (!is_file($filename)) {
            throw new FileNotFoundException($filename);
        }

        return $this->parse(explode("\n", file_get_contents($filename)));
    }

    private function parse(array $fileContent): array
    {
        $data = [];

       foreach ($fileContent as $row) {
           if (empty($row)) {
               break;
           }

           $rowArray = json_decode($row, true);

            if ($rowArray) {
                $data[] = $rowArray;
            }
       }

        return $data;
    }
}
