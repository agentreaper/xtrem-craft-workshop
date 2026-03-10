<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\MissingExchangeRateException;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{

    public function test_Bank_returns_converted_float_when_converting_EUR_to_USD()
    {
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $amount = 10;
        $expected = 12;

        $result = $bank->convert($amount, Currency::EUR(), Currency::USD());

        $this->assertEquals($expected, $result);
    }

    public function test_Bank_returns_same_float_when_converting_EUR_to_EUR()
    {
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $amount = 10;
        $expected = 10;

        $result = $bank->convert($amount, Currency::EUR(), Currency::EUR());

        $this->assertEquals($expected, $result);
    }

    public function test_Bank_throws_MissingExchangeRateException_when_converting_without_rate()
    {
        $this->expectException(MissingExchangeRateException::class);
        $this->expectExceptionMessage('EUR->KRW');
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $amount = 10;

        $bank->convert($amount, Currency::EUR(), Currency::KRW());
    }

    public function test_Bank_returns_different_float_when_converting_with_updated_exchange_rate()
    {
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $amount = 10;

        $this->assertEquals(12, $bank->convert($amount, Currency::EUR(), Currency::USD()));

        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 1.3);

        $this->assertEquals(13, $bank->convert($amount, Currency::EUR(), Currency::USD()));
    }

}
