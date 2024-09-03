<?php

namespace App\Http\Livewire\Customer\Product;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewDetail extends Component
{
    public $product, $review, $reviewCount, $listReplyComment, $orderProductBuy, $selectedRating = null, $showFullDescription, $valueQty = 1;

    public $selectedCollectionId;

    public function addToCart()
    {
        $product = Product::find($this->product->id);
        if (Auth::guard('cus')->check()) {
            if ($product->productCollection->count()) {
                if ($this->selectedCollectionId) {
                    $cart = Cart::where('customer_id',(Auth::guard('cus')->user()->id))->where('product_id', $this->product->id)->where('product_collection_id', $this->selectedCollectionId)->first();
                    if ($this->valueQty && is_numeric($this->valueQty)) {
                        foreach ($this->product->productCollection as $value) {
                            if ($this->valueQty > $value->quantity) {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Số lượng hàng không đủ',
                                    'type' => 'error',
                                    'status' => 404
                                ]);
                                return;
                            }
                        }
                    } else {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Số lượng không được trống',
                            'type' => 'warning',
                            'status' => 404
                        ]);
                        return;
                    }
                    if (empty($cart)) {
                        Cart::create([
                            'customer_id' => Auth::guard('cus')->user()->id,
                            'product_id' => $product->id,
                            'product_collection_id' => $this->selectedCollectionId,
                            'quantity' => $this->valueQty,
                            'collection_id' => $this->selectedCollectionId,
                        ]);
                        $this->emit('CartAddedUpdated');
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Sản phẩm đã được thêm vào giỏ hàng',
                            'type' => 'success',
                            'status' => 404
                        ]);
                    } else {
                        if ($cart->product_collection_id == $this->selectedCollectionId) {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Sản phẩm đã có trong giỏ hàng',
                                'type' => 'info',
                                'status' => 404
                            ]);
                            return;
                        } else {
                            Cart::create([
                                'customer_id' => Auth::guard('cus')->user()->id,
                                'product_id' => $product->id,
                                'product_collection_id' => $this->selectedCollectionId,
                                'quantity' => $this->valueQty,
                                'collection_id' => $this->selectedCollectionId,
                            ]);
                            $this->emit('CartAddedUpdated');
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Sản phẩm đã được thêm vào giỏ hàng',
                                'type' => 'success',
                                'status' => 404
                            ]);
                        }
                    }
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Vui lòng chọn loại sản phẩm',
                        'type' => 'warning',
                        'status' => 404
                    ]);
                    return;
                }
            } else {
                $cart = Cart::where('customer_id',(Auth::guard('cus')->user()->id))->where('product_id', $this->product->id)->first();
                if (isset($cart)) {
                    if ($cart->product_id == $this->product->id) {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Sản phẩm đã có trong giỏ hàng',
                            'type' => 'info',
                            'status' => 404
                        ]);
                        return;
                    }
                } else {
                    Cart::create([
                        'customer_id' => Auth::guard('cus')->user()->id,
                        'product_id' => $product->id,
                        'quantity' => $this->valueQty,
                        'collection_id' => $this->selectedCollectionId,
                    ]);
                    $this->emit('CartAddedUpdated');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Sản phẩm đã được thêm vào giỏ hàng',
                        'type' => 'success',
                        'status' => 404
                    ]);
                }
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Vui lòng đăng nhập',
                'type' => 'error',
                'status' => 404
            ]);
        }
    }
    public function resetSelectedCollection()
    {
        $this->selectedCollectionId = null;
    }
    public function collectionPrice()
    {
        if ($this->selectedCollectionId) {
            foreach ($this->product->productCollection as $key => $value) {
                if ($value->id == $this->selectedCollectionId) {
                    return $value->price;
                }
            }
        }
    }
    public function plusQty()
    {
        $this->valueQty++;
    }

    public function minusQty()
    {
        if ($this->valueQty > 1) {
            $this->valueQty--;
        }
    }
    public function similarProducts()
    {
        $targetProduct = Product::find($this->product->id);
        $similarProducts = Product::where('id', '!=', $targetProduct->id)
            ->get()
            ->map(function ($product) use ($targetProduct) {
                $hammingDistance = 0;
                if ($product->category_id != $targetProduct->category_id) {
                    $hammingDistance++;
                }
                if ($product->brand_id != $targetProduct->brand_id) {
                    $hammingDistance++;
                }
                if ($product->is_new != $targetProduct->is_new) {
                    $hammingDistance++;
                }
                if ($product->is_trending != $targetProduct->is_trending) {
                    $hammingDistance++;
                }
                if ($product->is_discounted != $targetProduct->is_discounted) {
                    $hammingDistance++;
                }
                $similarity = 1 - ($hammingDistance / 6);
                return [
                    'product' => $product,
                    'similarity' => $similarity,
                ];
            })
            ->sortByDesc('similarity')
            ->take(5);
        return $similarProducts;
    }
    public function filterReviews($rating)
    {
        $this->selectedRating = $rating;
        $this->filterReviewsByRating();
    }
    public function isInWishlist($productId)
    {
        $customer = Auth::guard('cus')->user();

        if ($customer) {
            return $customer->wishlist->contains('product_id', $productId);
        }

        return false;
    }
    public function addToWishlist($productId)
    {
        if (Auth::guard('cus')->check()) {
            $customerId = Auth::guard('cus')->user()->id;
            $wishlistItem = Wishlist::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
                $message = 'Đã xóa khỏi danh sách yêu thích.';
            } else {
                Wishlist::create([
                    'customer_id' => $customerId,
                    'product_id' => $productId,
                ]);
                $message = 'Đã thêm vào danh sách yêu thích.';
            }
            $this->dispatchBrowserEvent('message', [
                'text' => $message,
                'type' => 'success',
                'status' => 200,
            ]);
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Bạn chưa đăng nhập.',
                'type' => 'error',
                'status' => 401,
            ]);
        }
    }

    public function filterReviewsByRating()
    {
        $product = $this->product;
        if ($this->selectedRating !== null) {
            $this->review = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->where('rating', $this->selectedRating)->get();
        } else {
            $this->review = Review::whereHas('orderItem', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->get();
        }
    }
    public function countReviewsByRating($rating)
    {
        $product = $this->product;
        return Review::whereHas('orderItem', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->where('rating', $rating)->count();
    }
    public function shouldShowDescriptionButtons()
    {
        $minLengthToShowButtons = 500;
        return strlen($this->product->description) > $minLengthToShowButtons;
    }
    public function showFullDescription()
    {
        $this->showFullDescription = true;
    }

    public function hideFullDescription()
    {
        $this->showFullDescription = false;
    }
    public function mount($product, $review, $reviewcount, $listReplyComment, $orderProductBuy)
    {
        $this->product = $product;
        $this->review = $review;
        $this->reviewCount = $reviewcount;
        $this->listReplyComment = $listReplyComment;
        $this->orderProductBuy = $orderProductBuy;
        $this->filterReviewsByRating();
    }
    public function render()
    {

        $similarProduct = $this->similarProducts();
        return view(
            'livewire.customer.product.view-detail',
            [
                'similarProduct' => $similarProduct,
                'review' => $this->review,
                'reviewCount' => $this->reviewCount,
                'listReplyComment' => $this->listReplyComment,
                'orderProductBuy' => $this->orderProductBuy,
            ]
        );
    }
}
