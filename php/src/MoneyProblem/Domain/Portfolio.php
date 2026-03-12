<?php

namespace MoneyProblem\Domain;


class Portfolio
{
    public $currency_map = [];
    public $currencies = [];

    private function __construct()
    {
    }

    public static function create(Currency $currency, float $montant)
    {
        $portfolio = new Portfolio();
        $portfolio->add_to_portfolio($currency,$montant);

        return $portfolio;
    }

    public function add_to_portfolio(Currency $c, float $m)
    {
        $this->currencies[] = $m;
        $this->currency_map["{$c}"] = $m;
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
    public function getCurrencyMap(): array
    {
        return $this->currency_map;
    }


    public function evaluate(Bank $banq, Currency $to): float
    {
        $total = 0;
        foreach($this->getCurrencyMap() as $from => $amount){
            $from_c = Currency::fromString($from);
            if($banq->currencyIsSupported($from, $to)) {
                $total += $banq->convert($amount, $from_c , $to);
            } else {
                throw new \Exception("Currency not supported.", 1);
            }
        }
        return $total;
    }


}