<?php

namespace MoneyProblem\Domain;


class Portfolio
{
    public $currency_map = [];
    public $currencies = [];

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
        $this->currencies[] = $money->getAmount();
        $this->currency_map["{$money->getCurrency()}"] = $money->getAmount();
    }

    public function remove_from_portfolio(Currency $c, float $m)
    {
        // supprimer $this->currency_map->$c = $m;
        // enlever de $currencies
    }

    /**
     * Retourne la map currency => montant (les clés sont des strings comme 'USD')
     * @return array
     */
    private function getCurrencyMap(): array
    {
        return $this->currency_map;
    }


    public function evaluate(Bank $banq, Currency $to): Money
    {
        $total = 0;
        foreach($this->getCurrencyMap() as $from => $amount){
            $from_c = Currency::fromString($from);
            if($banq->currencyIsSupported($from, $to)) {
                $money = new Money($amount, $from_c);
                $convertedMoney = $banq->convert($money, $to);
                $total += $convertedMoney->getAmount();
            } else {
                throw new \Exception("Currency not supported.", 1);
            }
        }
        return new Money($total, $to);
    }


}