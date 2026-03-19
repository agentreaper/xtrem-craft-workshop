<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\Money;
use MoneyProblem\Domain\MissingExchangeRateException;
use PHPUnit\Framework\TestCase;

require_once 'BankBuilder.php';

class BankTest extends TestCase
{

    public function test_Bank_returns_converted_float_when_converting_EUR_to_USD()
    {
        $bank = (new BankBuilder())->build();
        $money = new Money(10, Currency::EUR());
        $expected = new Money(12, Currency::USD());

        $result = $bank->convert($money, Currency::USD());

        $this->assertEquals($expected->getAmount(), $result->getAmount());
    }

    public function test_Bank_returns_same_float_when_converting_EUR_to_EUR()
    {
        $bank = (new BankBuilder())->build();
        $money = new Money(10, Currency::EUR());
        $expected = new Money(10, Currency::EUR());

        $result = $bank->convert($money, Currency::EUR());

        $this->assertEquals($expected->getAmount(), $result->getAmount());
    }

    public function test_Bank_throws_MissingExchangeRateException_when_converting_without_rate()
    {
        $this->expectException(MissingExchangeRateException::class);
        $this->expectExceptionMessage('EUR->KRW');
        $bank = (new BankBuilder())->build();
        $money = new Money(10, Currency::EUR());

        $bank->convert($money, Currency::KRW());
    }

    public function test_Bank_returns_different_float_when_converting_with_updated_exchange_rate()
    {
        $bank = (new BankBuilder())->build();
        $money = new Money(10, Currency::EUR());

        $this->assertEquals(12, $bank->convert($money, Currency::USD())->getAmount());

        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 1.3);

        $this->assertEquals(13, $bank->convert($money, Currency::USD())->getAmount());
    }

}
