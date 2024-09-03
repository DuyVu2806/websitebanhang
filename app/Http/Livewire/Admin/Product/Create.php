<?php

namespace App\Http\Livewire\Admin\Product;

use App\Http\Livewire\Quill;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GRN;
use App\Models\GRN_detail;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $showClassificationFields = false;
    public $classificationRows = [];
    public $storekeeper, $receiving_clerk, $supplier, $total_price;
    public $product_code, $name, $slug, $category_id, $brand_id, $image, $images = [];
    public $quantity, $price, $small_description, $description, $transportation;
    public $imageTemporaryUrl, $is_new = false, $is_trending = false;
    public $height, $weight, $width, $length, $original_price;


    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];
    public function quill_value_updated($value)
    {
        $this->description = $value;
    }
    public function dehydrate()
    {
        Session::forget('temporaryImage');
    }
    public function resetInput()
    {
        $this->storekeeper = NULL;
        $this->receiving_clerk = NULL;
        $this->supplier = NULL;
        $this->total_price = NULL;
        $this->product_code = NULL;
        $this->name = NULL;
        $this->slug = NULL;
        $this->category_id = NULL;
        $this->brand_id = NULL;
        $this->images = NULL;
        $this->images = [];
        $this->quantity = NULL;
        $this->original_price = NULL;
        $this->price = NULL;
        $this->small_description = NULL;
        $this->description = NULL;
        $this->transportation = NULL;
        $this->height  = NULL;
        $this->weight  = NULL;
        $this->width  = NULL;
        $this->length  = NULL;
        $this->classificationRows = [];
        Session::forget('temporaryImage');
    }
    public function removeClassificationRow($index)
    {
        unset($this->classificationRows[$index]);
        $this->classificationRows = array_values($this->classificationRows);
    }
    public function updatedImage($value)
    {
        if ($value) {
            $this->imageTemporaryUrl = $value->temporaryUrl();
            Session::put('temporaryImage', $this->imageTemporaryUrl);
        }
    }
    public function addClassificationRow()
    {
        $this->classificationRows[] = [
            'name_collection' => '',
            'quantity_collection' => '',
            'price_collection' => '',
        ];
    }
    public function addDescription($html)
    {
        $this->description = $html;
    }
    public function rules()
    {
        $rules = [
            'storekeeper' => 'required|string',
            'receiving_clerk' => 'required|string',
            'supplier' => 'required',
            'total_price' => 'required',
            'product_code' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'small_description' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'original_price' => 'required',
            'price' => 'required',
            'image' => 'required|image',
            'transportation' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'width' => 'required',
            'length' => 'required',
        ];

        if ($this->showClassificationFields) {
            foreach ($this->classificationRows as $index => $classification) {
                $rules["classificationRows.{$index}.name_collection"] = 'required';
                $rules["classificationRows.{$index}.quantity_collection"] = 'required|numeric|min:1';
                $rules["classificationRows.{$index}.price_collection"] = 'required|numeric|min:0';
            }
        }
        return $rules;
    }

    public function createProduct()
    {

        $validatedData = $this->validate();

        $this->updatedImage($this->image);
        if ($this->showClassificationFields && $this->classificationRows) {
            $totalClassificationQuantity = 0;
            foreach ($this->classificationRows as $classification) {
                $totalClassificationQuantity += $classification['quantity_collection'];
            }

            if ($this->quantity != $totalClassificationQuantity) {
                $this->addError('quantity', 'Tổng số lượng các loại sản phẩm không bằng số lượng nhập hàng.');
                return;
            }
        }

        $grn = GRN::create([
            'storekeeper' => $this->storekeeper,
            'receiving_clerk' => $this->receiving_clerk,
            'supplier' => $this->supplier,
            'total_price' => $this->total_price,
        ]);
        if ($this->image) {
            $uploadPath = 'public/product';
            $file = $this->image;
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->storeAs($uploadPath, $filename);
            $finalImagePathName = 'storage/product/' . $filename;
        }
        $productData = [
            'product_code' => $this->product_code,
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'image' => $finalImagePathName,
            'small_description' => $this->small_description,
            'description' =>  $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'is_new' => $this->is_new,
            'is_trending' => $this->is_trending,
            'height' => $this->height,
            'weight' => $this->weight,
            'width' => $this->width,
            'length' => $this->length,
        ];
        $product = Product::create($productData);

        GRN_detail::create([
            'grn_id' => $grn->id,
            'product_code' => $product->product_code,
            'quantity' => $product->quantity,
            'original_price' => $this->original_price,
            'price' => $product->price,
            'transportation' => $this->transportation,
        ]);
        if ($this->showClassificationFields) {
            foreach ($this->classificationRows as $classification) {
                $classificationRecord = new ProductCollection();
                $classificationRecord->product_id = $product->id;
                $classificationRecord->name_collection = $classification['name_collection'];
                $classificationRecord->quantity = $classification['quantity_collection'];
                $classificationRecord->price = $classification['price_collection'];

                $classificationRecord->save();
            }
        }

        foreach ($this->images as $image) {
            $uploadPath = 'public/product';
            $file = $image;
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->storeAs($uploadPath, $filename);
            $finalImagePathName = 'storage/product/' . $filename;

            $imageRecord = new ProductImage();
            $imageRecord->product_id = $product->id;
            $imageRecord->image = $finalImagePathName;

            $imageRecord->save();
        }
        session()->flash('message', 'Thêm Sản Phẩm Thành Công');
        Session::forget('temporaryImage');
        $this->resetInput();
    }
    public function mount()
    {
        $this->receiving_clerk = auth()->guard('admin')->user()->fullname;
        if (Session::has('temporaryImage')) {
            $this->imageTemporaryUrl = Session::get('temporaryImage');
        }
    }
    public function render()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('livewire.admin.product.create', ['categories' => $categories, 'brands' => $brands]);
    }
}
