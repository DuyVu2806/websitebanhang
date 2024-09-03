<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GRN;
use App\Models\GRN_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:admin|add product', ['except' => ['index']]);
    }
    function index()
    {
        $products = Product::OrderBy('created_at', 'DESC')->get();
        return view('admin.product.index', compact('products'));
    }
    function create()
    {
        return view('admin.product.create');
    }

    function createQty()
    {
        return view('admin.product.createQty');
    }

    function post_createQty(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'storekeeper' => 'required',
                'receiving_clerk' => 'required',
                'supplier' => 'required',
                'total_price' => 'required|numeric|min:0',
                'transportation' => 'required',
                'products.*.code' => 'required|exists:products,product_code',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.price' => 'required|numeric|min:0',
                'products.*.collections.*.name_collection' => 'required',
                'products.*.collections.*.quantity' => 'required|integer|min:0',
                'products.*.collections.*.price' => 'required|numeric|min:0',
            ],
            [
                'storekeeper.required' => 'Thủ kho không để trống',
                'receiving_clerk.required' => 'Người ghi nhập không để trống',
                'supplier.required' => 'Nhà cung cấp không được để trống',
                'total_price.required' => 'Tổng số tiền không được để trống',
                'total_price.numeric' => 'Tổng số tiền phải là số',
                'transportation.required' => 'Vận chuyển không được để trống',
                'products.*.code.required' => 'Mã sản phẩm không được để trống',
                'products.*.quantity.required' => 'Số lượng thêm không được để trống',
                'products.*.quantity.integer' => 'Số lượng thêm phải là số',
                'products.*.price.required' => 'Giá tiền không được để trống',
                'products.*.price.numeric' => 'Giá tiền phải là số',
                'products.*.collections.*.name_collection.required' => 'Tên loại sản phẩm không để trống',
                'products.*.collections.*.quantity.required' => 'Số lượng không được để trống',
                'products.*.collections.*.quantity.integer' => 'Số lượng phải là số',
                'products.*.collections.*.price.required' => 'Giá tiền không được để trống',
                'products.*.collections.*.price.numeric' => 'Giá tiền phải là số',
                'products.*.code.exists' => 'Mã sản phẩm không tồn tại',
                'products.*.quantity.min' => 'Số lượng sản phẩm phải lớn hơn hoặc bằng 1',
                'products.*.price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0',
                'products.*.collections.*.quantity.min' => 'Số lượng loại sản phẩm phải lớn hơn hoặc bằng 0',
                'products.*.collections.*.price.min' => 'Giá loại sản phẩm phải lớn hơn hoặc bằng 0',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $errors = [];
        $grnData = $request->only(['storekeeper', 'receiving_clerk', 'supplier', 'total_price']);
       
        $productsData = $request->input('products');

        foreach ($productsData as $key => $productData) {
            $prodQty = 0;
            $product = Product::where('product_code', $productData['code'])->first();
            if (!empty($productData['collections'])) {
                foreach ($productData['collections'] as $collectionData) {
                    $prodQty += $collectionData['quantity'];
                }
                if ($prodQty != $productData['quantity']) {
                    $errors['products.' . $key . '.quantity'] = ['Tổng số lượng của các loại sản phẩm không bằng số lượng của sản phẩm'];
                }
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $grn = GRN::create($grnData);
        foreach ($productsData as $productData) {
            $grnDetailData = [
                'grn_id' => $grn->id,
                'product_code' => $productData['code'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
                'transportation' => $request['transportation']
            ];
            
            GRN_detail::create($grnDetailData);
            
            $product = Product::where('product_code', $productData['code'])->first();
            if (isset($productData['collections'])) {
                foreach ($productData['collections'] as $collectionData) {
                    if (isset($collectionData['id'])) {
                        $collection = $product->productCollection->where('id', $collectionData['id'])->first();
                        $prodQty += $collectionData['quantity'];
                        $collection->update([
                            'name_collection' => $collectionData['name_collection'],
                            'quantity' => $collectionData['quantity'] + $collection->quantity,
                            'price' => $collectionData['price'],
                        ]);
                    } else {
                        $product->productCollection()->create([
                            'name_collection' => $collectionData['name_collection'],
                            'quantity' => $collectionData['quantity'],
                            'price' => $collectionData['price']
                        ]);
                    }
                }
            }
            $product->update([
                'price' => $productData['price'],
                'quantity' => $productData['quantity'] + $product->quantity,
            ]);
        }

        return response()->json(['message' => 'Dữ liệu đã được lưu thành công']);
    }

    function update($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.update', compact('product'));
    }

    function delete($product_id)
    {
    }

    // API
    function getProduct($product_code)
    {
        $product = Product::where('product_code', $product_code)->with('productCollection')->first();

        return response()->json(['product' => $product, 'collection' => $product->productCollection]);
    }
}
