<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\MoneyCalculator;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_MoneyCalculator_returns_float_when_adding_two_values_in_USD()
    {
        $value1 = 5;
        $value2 = 10;

        $result = MoneyCalculator::add($value1, $value2);

        $this->assertIsFloat($result);
        $this->assertNotNull($result);
    }

    public function test_MoneyCalculator_returns_positive_number_when_multiplying_values_in_EUR()
    {
        $value = 10;
        $multiplier = 2;

        $result = MoneyCalculator::times($value, $multiplier);

        $this->assertGreaterThan(0, $result);
    }

    public function test_MoneyCalculator_returns_float_when_dividing_values_in_KRW()
    {
        $value = 4002;
        $divisor = 4;
        $expected = 1000.5;

        $result = MoneyCalculator::divide($value, $divisor);

        $this->assertEquals($expected, $result);
    }
}
