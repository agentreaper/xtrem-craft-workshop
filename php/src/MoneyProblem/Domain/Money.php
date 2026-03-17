<?php

namespace MoneyProblem\Domain;
class Money
{
    private float $amount;
    private Currency $currency;

    /**
     * @param float $amount
     * @param Currency $currency
     */
    public function __construct(float $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function times(int $value): Money
    {
        return new Money(MoneyCalculator::times($this->amount, $value), $this->currency);
    }

    public function divide(int $value): Money
    {
        return new Money(MoneyCalculator::divide($this->amount, $value), $this->currency);
    }

    public function add(Money $money): Money
    {
        if ($this->currency != $money->getCurrency()) {
            throw new \InvalidArgumentException("Pas la même monnaie");
        }
        return new Money(MoneyCalculator::add($this->amount, $money->getAmount()), $this->currency);
    }

}