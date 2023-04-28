<?php

namespace App\Taxes;


class Detector
{
    public function detect(float $amount): bool
    {
        if ($amount >= 100) {
            return true;
        } else {
            return false;
        }
    }
}
