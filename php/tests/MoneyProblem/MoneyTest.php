<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_5_USD_plus_10_USD_equals_15_USD()
    {
        $money1 = new Money(5, Currency::USD());
        $money2 = new Money(10, Currency::USD());

        $result = $money1->add($money2);

        $this->assertEquals(new Money(15, Currency::USD()), $result);
    }

    public function test_10_EUR_times_2_equals_20_EUR()
    {
        $money = new Money(10, Currency::EUR());

        $result = $money->times(2);

        $this->assertEquals(new Money(20, Currency::EUR()), $result);
    }

    public function test_4002_KRW_divided_by_4_equals_1000_5_KRW()
    {
        $money = new Money(4002, Currency::KRW());

        $result = $money->divide(4);

        $this->assertEquals(new Money(1000.5, Currency::KRW()), $result);
    }
}
