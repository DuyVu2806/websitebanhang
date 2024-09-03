<?php

namespace App\Http\Livewire\Customer\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllProduct extends Component
{
    public $products, $brands, $categories, $brandInputs = [], $priceInputs, $cateInputs = [];
    public $keyword, $search;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'search'],
        'cateInputs' => ['except' => '', 'as' => 'category'],
        'brandInputs' => ['except' => '', 'as' => 'brand'],
        'priceInputs' => ['except' => '', 'as' => 'price'],
    ];
    public function sortProducts($sortType)
    {
        $this->priceInputs = $sortType;
        $this->render();
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
    public function performSearch()
    {
        $this->search = $this->keyword;
        $this->render();
    }
    public function render()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
        $query = Product::where('status', '0');
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->cateInputs)) {
            $query->whereIn('category_id', $this->cateInputs);
        }
        
        if (!empty($this->brandInputs)) {
            $query->whereIn('brand_id', $this->brandInputs);
        }

        if (!empty($this->priceInputs)) {
            $query->when($this->priceInputs, function ($q) {
                $q->when($this->priceInputs == 'high-to-low', function ($e) {
                    $e->orderBy('price', 'DESC');
                })
                    ->when($this->priceInputs == 'low-to-high', function ($e) {
                        $e->orderBy('price', 'ASC');
                    });
            });
        }
    
        $this->products = $query->get();



        return view('livewire.customer.product.all-product', [
            'products' => $this->products,
            'categories' => $this->categories,
            'brands' => $this->brands
        ]);
    }
}
