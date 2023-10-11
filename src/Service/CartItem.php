<?php

namespace App\Service;

use App\Entity\Product;

class CartItem
{
    public Product $product;
    public int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
