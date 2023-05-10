<?php

declare(strict_types=1);

namespace App;

class Calculator
{
    public function calculate(string $currency, float $amount, float $rate, float $discount): float
    {
        $amountFixed = 0;

        if ($currency === 'EUR' || $rate == 0) {
            $amountFixed = $amount;
        }

        if ($currency !== 'EUR' || $rate > 0) {
            $amountFixed = $amount / $rate;
        }

        return round($amountFixed * $discount, 2);
    }
}
