<?php

declare(strict_types=1);

use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function calculate(): void
    {
        $calculator = new Calculator();
        $result = $calculator->calculate('GBP', 2000.00, 132.360679, 0.02);

        $this->assertSame(0.3, $result);
    }
}
