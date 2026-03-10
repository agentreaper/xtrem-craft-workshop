<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\MoneyCalculator;
use PHPUnit\Framework\TestCase;
use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;

class PortfolioTest extends TestCase
{
    public function given_portfolio_empty_when_evaluating_then_returns_zero():void
    {
        $portfolio = Portfolio::create(0,Currency::EUR());
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1);
        
        $result = $bank->evaluate($portfolio,Currency::USD());
        
        $this->assertEquals(0, $result);
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
