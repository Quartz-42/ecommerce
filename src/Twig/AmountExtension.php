<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AmountExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'amount']),
        ];
    }

    public function amount(int $value, string $symbol = '€', string $decimalSeparator = ',', string $thousandSeparator = ' '): string
    {
        $finalValue = $value / 100;
        $finalValue = number_format($finalValue, 2, $decimalSeparator, $thousandSeparator);

        return $finalValue.' '.$symbol;
    }
}
