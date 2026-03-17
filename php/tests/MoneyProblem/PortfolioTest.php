<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\MoneyCalculator;
use PHPUnit\Framework\TestCase;
use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\Money;
use MoneyProblem\Domain\Portfolio;


class PortfolioTest extends TestCase
{
    public function test_given_portfolio_empty_when_evaluating_then_returns_zero()
    {
        $portfolio = Portfolio::create(new Money(0, Currency::EUR()));
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1);
        
        $result = $portfolio->evaluate($bank,Currency::USD());
        $this->assertEquals(0, $result->getAmount());
    }

    public function test_given_portfolio_with_money_when_evaluating_then_returns_correct_total()
    {
        $portfolio = Portfolio::create(new Money(100, Currency::USD()));
        $bank = Bank::create(Currency::USD(), Currency::USD(), 1);
        
        $result = $portfolio->evaluate($bank,Currency::USD());
        $this->assertEquals(100, $result->getAmount());
    }

    public function test_given_portfolio_with_multiple_currencies_when_evaluating_then_returns_correct_total()
    {
        $portfolio = new \ReflectionClass('MoneyProblem\\Domain\\Portfolio');
        $instance = $portfolio->newInstanceWithoutConstructor();
        $currencyMapProperty = $portfolio->getProperty('currency_map');
        $currencyMapProperty->setAccessible(true);
        $currencyMapProperty->setValue($instance, [
            'USD' => 100,
            'EUR' => 50
        ]);
        
        $bank = new Bank([]);
        $bank->addEchangeRate(Currency::USD(), Currency::USD(), 1);
        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 0.5); 
        
        $result = $instance->evaluate($bank, Currency::USD());
        
        
        $this->assertEquals(125, $result->getAmount());
    }

}
