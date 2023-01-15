<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductsDisplay extends Component
{
    public function __construct(public $products)
    {
    }

    public function render()
    {
        return view('components.products-display');
    }
}
