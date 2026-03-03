<?php

namespace MoneyProblem\Domain;

class MoneyCalculator
{
    /**
     * Addition entre deux monnaies
     */
    public static function add(float $amount, float $amount2): float
    {
        return $amount + $amount2;
    }

    /**
     * Multiplication entre deux monnaies
     */
    public static function times(float $amount, int $value): float
    {
        return $amount * $value;
    }

    /**
     * Division entre deux monnaies
     */
    public static function divide(float $amount, int $value): float
    {
        return $amount / $value;
    }
}