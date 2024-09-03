<?php

namespace App\Http\Livewire\Customer\Checkout;

use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetai;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutView extends Component
{
    public $carts, $customerAddress, $totalProductAmount = 0, $cartCount = 0;
    public $fullname, $phone, $city, $city_code, $district, $district_code, $ward, $ward_code, $address;
    public $fullname_address, $phone_address, $city_address, $district_address, $ward_address, $address2, $email, $total_price;
    public $showChildModal = false;
    public $fee;

    public $payment_mode = 'Cash On Delivery', $payment_id = NULL;

    protected $listeners = [
        'updateCodes' => 'updateCodes',
        'resetAddToAddress' => 'resetAddToAddress',
        'resetAddressFields' => 'resetAddressFields',
        'updateTotalFee' => 'updateFee'
    ];
    public function updateFee($totalFee)
    {
        $this->fee = $totalFee;
    }

    public function ItemsData()
    {
        $itemProd = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->get();
        $itemsData = [];
        foreach ($itemProd as $value) {
            $item = [
                'name' => $value->product->name, // Thay $value->name bằng tên cột trong bảng Cart tương ứng
                'quantity' => $value->quantity, // Tương tự, thay $value->quantity bằng tên cột trong bảng Cart
                'height' => $value->product->height, // Và tiếp tục
                'weight' => $value->product->weight,
                'length' => $value->product->length,
                'width' => $value->product->width,
            ];
            $itemsData[] = $item;
        }
        return json_encode($itemsData);
    }
    public function totalWeight(){
        $item = 0;
        $itemProd = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->get();
        foreach ($itemProd as $value) {
            $item += $value->product->weight*$value->quantity;
        }
        return json_encode($item);
    }
    public function resetAddToAddress()
    {
        $this->fullname = null;
        $this->phone = null;
        $this->city = null;
        $this->district = null;
        $this->ward = null;
        $this->address = null;
        $this->city_code = null;
        $this->district_code = null;
        $this->ward_code = null;
    }
    public function updateCodes($cityCode, $districtCode, $wardCode)
    {
        $this->city_code = $cityCode;
        $this->district_code = $districtCode;
        $this->ward_code = $wardCode;
    }
    public function resetAddressFields($key)
    {
        switch ($key) {
            case '1':
                $this->district = null;
                $this->ward = null;
                break;
            case '2':
                $this->ward = null;
                break;
            case '3':
                $this->district_address = null;
                $this->ward_address = null;
                break;
            case '4':
                $this->ward_address = null;
                break;
        }
    }

    public function addToAddress()
    {
        $validatedData = $this->validate([
            'fullname' => 'required',
            'phone' => 'required|numeric|digits:10',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required'
        ], [
            'fullname.required' => 'Họ và tên không được để trống.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',
            'city.required' => 'Tỉnh/Thành phố không được để trống.',
            'district.required' => 'Quận/Huyện không được để trống.',
            'ward.required' => 'Phường/Xã không được để trống.',
            'address.required' => 'Địa chỉ không được để trống.',
        ]);
        $address = [
            'customer_id' => Auth::guard('cus')->user()->id,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'province' => $this->city,
            'province_code' => $this->city_code,
            'district' => $this->district,
            'district_code' => $this->district_code,
            'wards' => $this->ward,
            'wards_code' => $this->ward_code,
            'address' => $this->address,
        ];
        CustomerAddress::create($address);
        $this->emit('showParentModal');
        $this->resetAddToAddress();
    }
    public function clickAddress($cusAddressId)
    {
        $cusAddress = CustomerAddress::where('id', $cusAddressId)->where('customer_id', Auth::guard('cus')->user()->id)->first();
        $cusAddress->update(['selected' => 1]);
        CustomerAddress::where('id', '!=', $cusAddressId)
            ->where('customer_id', Auth::guard('cus')->user()->id)
            ->update(['selected' => 0]);
        $this->fullname_address = $cusAddress->fullname;
        $this->phone_address = $cusAddress->phone;
        $this->city_address = $cusAddress->province;
        $this->district_address = $cusAddress->district;
        $this->ward_address = $cusAddress->wards;
        $this->address2 = $cusAddress->address;
        $this->emit('addressDataChanged', $cusAddress->province_code, $cusAddress->district_code, $cusAddress->wards_code);
        $this->emit('hideParentModal');
    }
    public function deleteAddress($id)
    {
        $CusAddress = CustomerAddress::findOrFail($id);
        if ($CusAddress) {
            $CusAddress->delete();
        }
    }
    public function payment()
    {
                // dd($this->total_price);
        $validatedData = $this->validate([
            'fullname_address' => 'required',
            'email' => 'required|email',
            'phone_address' => 'required|numeric|digits:10',
            'city_address' => 'required',
            'district_address' => 'required',
            'ward_address' => 'required',
        ], [
            'fullname_address.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Đây không phải email!',
            'phone_address.required' => 'Số điện không được để trống',
            'phone_address.numeric' => 'Số điện thoại phải là số',
            'phone_address.digits' => 'Số điện thoại phải 10 chữ số',
            'city_address.required' => 'Tình/Thành phố không được để trống',
            'district_address.required' => 'Quận/Huyện không được để trống',
            'ward_address.required' => 'Phường/Xã không được để trống',
        ]);
        $dataOrder = [
            'customer_id' => Auth::guard('cus')->user()->id,
            'fullname' => $this->fullname_address,
            'email' => $this->email,
            'phone' => $this->phone_address,
            'province' => $this->city_address,
            'province_code' => $this->city_code,
            'district' => $this->district_address,
            'district_code' => $this->district_code,
            'wards' => $this->ward_address,
            'wards_code' => $this->ward_code,
            'address' => $this->address2,
            'payment_mode' => $this->payment_mode,
            'total_price' => $this->total_price,
        ];
        // dd($dataOrder);
        $order = Order::create($dataOrder);
        $prodOrder = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->get();
        foreach ($prodOrder as $value) {
            $product = Product::findOrFail($value->product_id);
            if ($value->product_collection_id) {
                $productCollection = ProductCollection::findOrFail($value->product_collection_id);
                $dataOrderDetail = [
                    'order_id' => $order->id,
                    'product_id' => $value->product_id,
                    'product_collection_id' => $value->product_collection_id,
                    'quantity' => $value->quantity,
                    'price' => $value->productCollection->price,
                ];
                $product->update([
                    'quantity' => $product->quantity - $value->quantity
                ]);
                $productCollection->update([
                    'quantity' => $productCollection->quantity - $value->quantity
                ]);
            } else {
                $dataOrderDetail = [
                    'order_id' => $order->id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'price' => $value->product->price,
                ];
                $product->update([
                    'quantity' => $product->quantity - $value->quantity
                ]);
            }
            OrderDetai::create($dataOrderDetail);
            $value->delete();
        }
        $this->emit('CartAddedUpdated');
    }

    public function initializeComponent()
    {
        if ($this->city_code && $this->district_code && $this->ward_code) {
            $this->emit('addressDataChanged', $this->city_code, $this->district_code, $this->ward_code);
        }
    }
    public function mount()
    {
        $this->ItemsData();
        $this->totalWeight();
        $cusAddress = CustomerAddress::where('selected', '1')->where('customer_id', Auth::guard('cus')->user()->id)->first();
        if ($cusAddress) {
            $this->fullname_address = $cusAddress->fullname;
            $this->phone_address = $cusAddress->phone;
            $this->email = Auth::guard('cus')->user()->email;
            $this->city_address = $cusAddress->province;
            $this->district_address = $cusAddress->district;
            $this->ward_address = $cusAddress->wards;
            $this->city_code = $cusAddress->province_code;
            $this->district_code = $cusAddress->district_code;
            $this->ward_code = $cusAddress->wards_code;
            $this->address2 = $cusAddress->address;
        }
    }
    public function render()
    {
        $this->cartCount = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->count();
        $this->carts = Cart::where('customer_id', Auth::guard('cus')->user()->id)->where('checkItem', '1')->get();
        $this->customerAddress = CustomerAddress::where('customer_id', Auth::guard('cus')->user()->id)->get();
        return view('livewire.customer.checkout.checkout-view');
    }
}
