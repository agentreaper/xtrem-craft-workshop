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

    public function test_given_portfolio_with_multiple_currencies_when_evaluating_then_returns_correct_total()
    {
        // This test will catch the mutants by verifying accumulation works correctly
        $portfolio = new \ReflectionClass('MoneyProblem\\Domain\\Portfolio');
        $instance = $portfolio->newInstanceWithoutConstructor();
        
        // Use reflection to set private currency_map property
        $currencyMapProperty = $portfolio->getProperty('currency_map');
        $currencyMapProperty->setAccessible(true);
        $currencyMapProperty->setValue($instance, [
            'USD' => 100,
            'EUR' => 50
        ]);
        
        $bank = new Bank([]);
        $bank->addEchangeRate(Currency::USD(), Currency::USD(), 1); // USD to USD (no conversion)
        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 0.5); // EUR to USD
        
        $result = $instance->evaluate($bank, Currency::USD());
        
        // 100 USD (no conversion needed) + 50 EUR * 0.5 = 100 + 25 = 125 USD
        $this->assertEquals(125, $result);
    }

}
