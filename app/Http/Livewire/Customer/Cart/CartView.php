<?php

namespace App\Http\Livewire\Customer\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartView extends Component
{
    public $carts, $cartCollec,$cartCount;

    public function minusQty($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('customer_id', Auth::guard('cus')->user()->id)->first();
        if ($cartData) {
            if ($cartData->quantity > 1) {
                $cartData->decrement('quantity');
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Không được quá 1 sản phẩm',
                    'type' => 'warning',
                    'status' => 404
                ]);
            }
        }
    }
    public function plusQty($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('customer_id', Auth::guard('cus')->user()->id)->first();
        if ($cartData) {
            if ($cartData->productCollection()->where('id', $cartData->product_collection_id)->exists()) {
                $productCollection = $cartData->productCollection()->where('id', $cartData->product_collection_id)->first();
                if ($productCollection->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Còn ' . $productCollection->quantity . ' Sản Phẩm',
                        'type' => 'warning',
                        'status' => 200
                    ]);
                }
            } else {
                if ($cartData->product->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Còn ' . $cartData->product->quantity . ' Sản Phẩm',
                        'type' => 'warning',
                        'status' => 200
                    ]);
                }
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Something Went Wrong',
                'type' => 'danger',
                'status' => 200
            ]);
        }
    }
    public function updateSelections($itemId)
    {
        Cart::where('id', $itemId)->update(['checkItem' => $this->cartCollec[$itemId]['checkItem']]);
    }
    public function removeCartItem($cartId)
    {
        $removeCart = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('id', $cartId)->first();

        if ($removeCart) {
            $removeCart->delete();
            $this->emit('CartAddedUpdated');
            $this->dispatchBrowserEvent('messageDelete', [
                'text' => 'Xóa Sản phẩm thành công',
                'type' => 'success',
                'status' => 404
            ]);
            
        }
    }
    public function mount()
    {
        $this->cartCollec = Cart::all()->keyBy('id')->toArray();
    }
    public function render()
    {
        $this->cartCount  = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->count();
        $this->carts = Cart::where('customer_id', Auth::guard('cus')->user()->id)->get();
        return view('livewire.customer.cart.cart-view', [
            'carts' => $this->carts,
            'cartCount' => $this->cartCount
        ]);
    }
}
