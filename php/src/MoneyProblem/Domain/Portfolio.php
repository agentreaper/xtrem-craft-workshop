<?php

namespace MoneyProblem\Domain;


class Portfolio
{
    private $currency_map = [];

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
        $this->currency_map->$c = $m;
    }


}