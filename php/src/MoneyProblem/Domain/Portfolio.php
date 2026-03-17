<?php

namespace MoneyProblem\Domain;


class Portfolio
{
    private array $moneys = [];

    private function __construct()
    {
    }

    public static function create(Money $money)
    {
        $portfolio = new Portfolio();
        $portfolio->add_to_portfolio($money);

        return $portfolio;
    }

    private function add_to_portfolio(Money $money)
    {
        $this->moneys[] = $money;
    }

    public function remove_from_portfolio(Money $moneyToRemove): void
    {
        foreach ($this->moneys as $index => $money) {
            if ($money->getCurrency() == $moneyToRemove->getCurrency() && $money->getAmount() === $moneyToRemove->getAmount()) {
                unset($this->moneys[$index]);
                $this->moneys = array_values($this->moneys);
                return;
            }
        }
    }

    public function evaluate(Bank $banq, Currency $to): Money
    {
        $total = 0;
        foreach ($this->moneys as $money) {
            $from = (string) $money->getCurrency();
            if ($banq->currencyIsSupported($from, (string) $to)) {
                $convertedMoney = $banq->convert($money, $to);
                $total += $convertedMoney->getAmount();
            } else {
                throw new \Exception("Currency not supported.", 1);
            }
        }
        return new Money($total, $to);
    }


}