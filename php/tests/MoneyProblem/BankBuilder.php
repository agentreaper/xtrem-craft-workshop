<?php

namespace Tests\MoneyProblem\Domain;

use MoneyProblem\Domain\Bank;
use MoneyProblem\Domain\Currency;

class BankBuilder
{
    private $from;
    private $to;
    private $rate;

    public function __construct()
    {
        $this->from = Currency::EUR();
        $this->to = Currency::USD();
        $this->rate = 1.2;
    }

    public function withFrom(Currency $from): BankBuilder
    {
        $this->from = $from;
        return $this;
    }

    public function withTo(Currency $to): BankBuilder
    {
        $this->to = $to;
        return $this;
    }

    public function withRate(float $rate): BankBuilder
    {
        $this->rate = $rate;
        return $this;
    }

    public function build(): Bank
    {
        return Bank::create($this->from, $this->to, $this->rate);
    }
}
