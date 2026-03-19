<?php

namespace Tests\MoneyProblem\Domain;

use PHPUnit\Framework\TestCase;
use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\Money;
use MoneyProblem\Domain\Portfolio;

require_once 'BankBuilder.php';


class PortfolioTest extends TestCase
{
    public function test_given_portfolio_empty_when_evaluating_then_returns_zero()
    {
        $portfolio = Portfolio::create(new Money(0, Currency::EUR()));
        # a refacto
        $bank = (new BankBuilder())->withFrom(Currency::EUR())->withTo(Currency::USD())->withRate(1)->build();
        
        $result = $portfolio->evaluate($bank,Currency::USD());
        $this->assertEquals(0, $result->getAmount());
    }

    public function test_given_portfolio_with_money_when_evaluating_then_returns_correct_total()
    {
        $portfolio = Portfolio::create(new Money(100, Currency::USD()));
        $bankbuilder = new BankBuilder();
        $bankbuilder ->withFrom(Currency::USD());
        $bankbuilder ->withTo(Currency::USD());
        $bankbuilder ->withRate(1);
        $bank = $bankbuilder ->build();
        
        $result = $portfolio->evaluate($bank,Currency::USD());
        $this->assertEquals(100, $result->getAmount());
    }

    public function test_given_portfolio_with_multiple_currencies_when_evaluating_then_returns_correct_total()
    {
        $portfolio = new \ReflectionClass('MoneyProblem\\Domain\\Portfolio');
        $instance = $portfolio->newInstanceWithoutConstructor();
        $moneysProperty = $portfolio->getProperty('moneys');
        $moneysProperty->setAccessible(true);
        $moneysProperty->setValue($instance, [
            new Money(100, Currency::USD()),
            new Money(50, Currency::EUR())
        ]);
        
        $bank = new Bank([]);
        $bank->addEchangeRate(Currency::USD(), Currency::USD(), 1);
        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 0.5); 
        
        $result = $instance->evaluate($bank, Currency::USD());
        
        
        $this->assertEquals(125, $result->getAmount());
    }

}
