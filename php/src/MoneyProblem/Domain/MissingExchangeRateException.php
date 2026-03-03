<?php

namespace MoneyProblem\Domain;

class MissingExchangeRateException extends \Exception
{

    /**
     * @param Currency $from
     * @param Currency $to
     */
    public function __construct(Currency $from, Currency $to)
    {
        parent::__construct(sprintf('%s->%s', $from, $to));

    }
}