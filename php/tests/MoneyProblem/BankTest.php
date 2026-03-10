<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;
use MoneyProblem\Domain\MissingExchangeRateException;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{

    public function test_given_eur_return_usd_as_float()
    {
        # $this->assertEquals(12, Bank::create(Currency::EUR(), Currency::USD(), 1.2)->convert(10, Currency::EUR(), Currency::USD()));
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $result = $bank->convert(10, Currency::EUR(), Currency::USD());
        $this->assertEquals(12, $result);

    }


    public function test_given_eur_return_eur_as_float()
    {
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);
        $result = $bank->convert(10, Currency::EUR(), Currency::EUR());
        $this->assertEquals(10, $result);
    }

    public function test_given_bank_missing_exchange_rate_return_exception()
    {
        $this->expectException(MissingExchangeRateException::class);
        $this->expectExceptionMessage('EUR->KRW');

        Bank::create(Currency::EUR(), Currency::USD(), 1.2)->convert(10, Currency::EUR(), Currency::KRW());
    }

    public function test_convert_with_different_exchange_rates_returns_different_floats()
    {
        $bank = Bank::create(Currency::EUR(), Currency::USD(), 1.2);

        $this->assertEquals(12, $bank->convert(10, Currency::EUR(), Currency::USD()));

        $bank->addEchangeRate(Currency::EUR(), Currency::USD(), 1.3);

        $this->assertEquals(13, $bank->convert(10, Currency::EUR(), Currency::USD()));
    }

}
