<?php

namespace MoneyProblem\Domain;

use function array_key_exists;

class Bank
{
    private $exchangeRates = [];

    /**
     * Constructeur de la classe Bank
     * @param array $exchangeRates Le tableau des taux de change 
     */
    public function __construct(array $exchangeRates = [])
    {
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * Fonction de création d'un taux de conversion 
     * @param Currency $from la monnaie initiale
     * @param Currency $to la monnaie finale
     * @param float $rate taux de conversion
     * @return Bank une instance de Bank avec le taux de conversion ajouté
     */
    public static function create(Currency $from, Currency $to, float $rate)
    {
        $bank = new Bank([]);
        $bank->addEchangeRate($from, $to, $rate);

        return $bank;
    }

    /**
     * Fonction pour ajouter un taux de conversion à la banque
     * @param Currency $from la monnaie initiale
     * @param Currency $to la monnaie finale
     * @param float $rate taux de conversion
     * @return void 
     */
    public function addEchangeRate(Currency $from, Currency $to, float $rate): void
    {
        $this->exchangeRates[($from . '->' . $to)] = $rate;
    }

    /**
     * Focntion de conversion entre deux monnaies
     * @param float $amount le montant
     * @param Currency $from la monnaie initiale
     * @param Currency $to la monnaie finale
     * @return float le résultat de la conversion
     * @throws MissingExchangeRateException l'exception en cas d'erreur de conversion
     */
    public function convert(float $amount, Currency $from, Currency $to): float
    {
        if (!($from == $to || array_key_exists($from . '->' . $to, $this->exchangeRates))) {
            throw new MissingExchangeRateException($from, $to);
        }
        return $from == $to
            ? $amount
            : $amount * $this->exchangeRates[($from . '->' . $to)];
    }

    public function evaluate(Portfolio $p, Currency $c): float
    {
        $total;
        if (in_array($c, $p->currency_map)){
            foreach ($p->currency_map as $cle => $valeur) {
                
            }
        }
    }

}