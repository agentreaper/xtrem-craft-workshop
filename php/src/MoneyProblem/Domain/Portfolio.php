<?php

namespace MoneyProblem\Domain;


class Portfolio
{
    private $currency_map = [];
    private $currencies = [];

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
        array_push($this->currencies, $m);
        $this->currency_map->$c = $m;
    }

    public function remove_from_portfolio(Currency $c, float $m)
    {
        // supprimer $this->currency_map->$c = $m;
        // enlever de $currencies
    }


}