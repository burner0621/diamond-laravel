<?php

namespace App\Models\Traits;

trait FormatPrices
{
    public function setPriceToFloat()
    {
        $this->price = number_format($this->price / 100, 2);
        return $this;
    }

    public static function stringPriceToCents(string $price)
    {
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '', $price);
        return (int) $price;
    }
}
