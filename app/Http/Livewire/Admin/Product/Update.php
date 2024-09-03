<?php

namespace App\Http\Livewire\Admin\Product;

use App\Http\Livewire\Quill;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;
    public $imageTemporaryUrl, $product, $temporaryImages = [];
    public $showClassificationFields = false;
    public $classificationRows = [], $test = 0;
    public $product_code, $name, $slug, $category_id, $brand_id, $price, $quantity, $small_description, $description, $image, $images = [];
    public $height, $weight, $width, $length;
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
        Session::forget('temporaryImages');
    }

    public function rules()
    {
        $rules = [
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
            'image' => 'required',
            'images.*' => 'required',
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
    public function addClassificationRow($name = '', $quantity = '', $price = '')
    {
        $this->classificationRows[] = [
            'name_collection' => $name,
            'quantity_collection' => $quantity,
            'price_collection' => $price,
        ];
    }
    public function updatedImage($value)
    {
        if ($value) {
            $this->imageTemporaryUrl = $value->temporaryUrl();
            Session::put('temporaryImage', $this->imageTemporaryUrl);
        }
    }
    public function updatedImages($value)
    {
        if ($value && is_array($value)) {
            foreach ($value as $image) {
                $temporaryUrl = $image->temporaryUrl();
                $this->temporaryImages[] = $temporaryUrl;
            }
            Session::put('temporaryImages', $this->temporaryImages);
        }
    }
    public function mount()
    {
        $this->product_code = $this->product->product_code;
        $this->name = $this->product->name;
        $this->slug = $this->product->slug;
        $this->category_id = $this->product->category_id;
        $this->brand_id = $this->product->brand_id;
        $this->small_description = $this->product->small_description;
        $this->description = $this->product->description;
        $this->image = $this->product->image;
        $this->images = $this->product->productImage;
        $this->height = $this->product->height;
        $this->weight = $this->product->weight;
        $this->width = $this->product->width;
        $this->length = $this->product->length;
        if ($this->product->productCollection->count() != 0) {
            $this->showClassificationFields = true;
            foreach ($this->product->productCollection as $collection) {
                $this->addClassificationRow(
                    $collection->name_collection,
                    $collection->quantity,
                    $collection->price,
                );
            }
        };
        $this->quantity = $this->product->quantity;
        $this->price = $this->product->price;
    }
    public function updateProduct()
    {
        $validatedData = $this->validate();
        if (is_array($this->image)) {
            $this->updatedImage($this->image);
        }

        $this->updatedImages($this->images);
        if ($this->product->image != $this->image) {
            if ($this->product->image) {
                Storage::delete('public/product/' . basename($this->product->image));
            }
            $uploadPath = 'public/product';
            $file = $this->image;
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->storeAs($uploadPath, $filename);
            $finalImagePathName = 'storage/product/' . $filename;
            $this->image = $finalImagePathName;
        }
        $this->product->update([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'small_description' => $this->small_description,
            'description' => $this->description,
            'image' => $this->image,
            'height' => $this->height,
            'weight' => $this->weight,
            'width' => $this->width,
            'length' => $this->length,
        ]);
        if (is_array($this->images)) {
            foreach ($this->product->productImage as $listImage) {
                Storage::delete('public/product/' . basename($listImage->image));
                $listImage->delete();
            }
            foreach ($this->images as $image) {
                $uploadPath = 'public/product';
                $file = $image;
                $ext = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $ext;
                $file->storeAs($uploadPath, $filename);
                $finalImagePathName = 'storage/product/' . $filename;

                $imageRecord = new ProductImage();
                $imageRecord->product_id = $this->product->id;
                $imageRecord->image = $finalImagePathName;

                $imageRecord->save();
            }
        }
        foreach ($this->classificationRows as $index => $classification) {
            $productCollection = $this->product->productCollection->get($index);

            if ($productCollection) {
                $productCollection->update([
                    'name_collection' => $classification['name_collection'],
                    'quantity' => $classification['quantity_collection'],
                    'price' => $classification['price_collection'],
                ]);
            } else {
                ProductCollection::create([
                    'product_id' => $this->product->id,
                    'name_collection' => $classification['name_collection'],
                    'quantity' => $classification['quantity_collection'],
                    'price' => $classification['price_collection'],
                ]);
            }
        }
        Session::forget('temporaryImage');
        Session::forget('temporaryImages');
        session()->flash('message', 'Chỉnh Sửa Sản Phẩm Thành Công');
    }
    public function render()
    {
        $categories = Category::withTrashed()->get();
        $brands = Brand::withTrashed()->get();
        return view('livewire.admin.product.update', ['categories' => $categories, 'brands' => $brands, 'product' => $this->product]);
    }
}
