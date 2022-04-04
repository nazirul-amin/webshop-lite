<?php

namespace App\Http\Livewire\Product;

use App\Models\Cart;
use Livewire\Component;

class ShoppingCart extends Component
{
    public function render()
    {
        $data['productInCarts'] = Cart::with('product')->get();
        $data['totalQuantity'] = 0;
        $data['totalPrice'] = 0.00;
        foreach($data['productInCarts'] as $product){
            $data['totalQuantity'] += $product->quantity;
            $data['totalPrice'] += $product->product->price * $product->quantity;
        }
        return view('livewire.product.shopping-cart', $data);
    }
}
