<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductForm extends Component
{
    public function __construct(public $product = null)
    {
    }

    public function render()
    {
        return view('components.product-form');
    }
}
