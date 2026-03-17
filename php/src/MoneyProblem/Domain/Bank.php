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
     * @param Money $money le montant et la monnaie initiale
     * @param Currency $to la monnaie finale
     * @return Money le résultat de la conversion
     * @throws MissingExchangeRateException l'exception en cas d'erreur de conversion
     */
    public function convert(Money $money, Currency $to): Money
    {
        $from = $money->getCurrency();
        $amount = $money->getAmount();
        if (!($from == $to || array_key_exists($from . '->' . $to, $this->exchangeRates))) {
            throw new MissingExchangeRateException($from, $to);
        }
        $convertedAmount = $from == $to
            ? $amount
            : $amount * $this->exchangeRates[($from . '->' . $to)];
        return new Money($convertedAmount, $to);
    }

    public function currencyIsSupported(String $from, String $to){
        return array_key_exists($from . '->' . $to, $this->exchangeRates);
    }

    

}