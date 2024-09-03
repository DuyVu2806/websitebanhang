<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;

class CreateQty extends Component
{
    public $storekeeper, $receiving_clerk, $supplier, $total_price, $transportation, $product;
    public $product_code, $name, $quantity, $price, $productCollections = [], $productFields = [];
    public $selectedProduct = null;

    public $showClassificationFields = false;

    public function __construct()
    {
        parent::__construct();

        $this->showClassificationFields = [];
    }
    public function addNewProduct()
    {
        $this->productFields[] = [
            'product_code' => '',
            'name' => '',
            'quantity' => '',
            'price' => '',
            'productCollections' => [],
        ];
        $newIndex = count($this->productFields) - 1;
        $this->productCollections[$newIndex] = [];
        $this->showClassificationFields[] = false;
    }

    public function addNewClassification($index, $name = '', $quantity = '', $price = '')
    {
        $this->productFields[$index]['productCollections'][] = [
            'name_collection' => $name,
            'quantity' => $quantity,
            'price' => $price,
        ];
    }
    public function updateProductCollection($index, $item, $field, $value)
    {
        $this->productCollections[$index][$item][$field] = $value;
    }
    public function removeClassification($index, $item)
    {
        if (isset($this->productFields[$index]['productCollections'][$item])) {
            unset($this->productFields[$index]['productCollections'][$item]);
        }
    }
    public function findProductName($index)
    {
        $productCode = $this->productFields[$index]['product_code'];
        $product = Product::where('product_code', $productCode)->first();
        if ($product) {
            $this->productCollections[$index] = $product->productCollection->toArray();
            $this->productFields[$index]['productCollections'] = $product->productCollection->toArray();
            $this->showClassificationFields[$index] = true;
            $this->productFields[$index]['name'] = $product->name;
        } else {
            $this->showClassificationFields[$index] = false;
        }

        $this->selectedProduct = $product;
    }
    
    public function mount()
    {
    }
    public function createQty()
    {
    }
    public function render()
    {
        return view('livewire.admin.product.create-qty');
    }
}
