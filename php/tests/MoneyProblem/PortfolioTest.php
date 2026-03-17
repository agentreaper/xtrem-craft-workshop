<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\MoneyCalculator;
use PHPUnit\Framework\TestCase;
use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\Portfolio;


class PortfolioTest extends TestCase
{
    public function test_given_portfolio_empty_when_evaluating_then_returns_zero()
    {
        $portfolio = Portfolio::create(Currency::EUR(), 0);
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1);
        
        $result = $portfolio->evaluate($bank,Currency::USD());
        $this->assertEquals(0, $result);
    }

}
