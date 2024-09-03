<?php

namespace App\Http\Livewire\Customer\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount;

    protected $listeners = [
        'CartAddedUpdated' => 'checkCartCount'
    ];
    public function checkCartCount()
    {
        if (Auth::guard('cus')->check()) {
            return $this->cartCount = Cart::where('customer_id', auth()->guard('cus')->user()->id)->count();
        } else {
            return $this->cartCount = 0;
        }
    }
    public function render()
    {
        $this->cartCount = $this->checkCartCount();
        return view('livewire.customer.cart.cart-count', [
            'cartCount' => $this->cartCount,
        ]);
    }
}
