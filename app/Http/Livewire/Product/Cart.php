<?php

namespace App\Http\Livewire\Product;

use App\Models\Cart as ModelsCart;
use Livewire\Component;

class Cart extends Component
{
    protected $listeners = [
        'addedToCart' => 'render'
    ];

    public function render()
    {
        $data['productInCarts'] = ModelsCart::with('product')->get();
        return view('livewire.product.cart', $data);
    }
}
