<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $name, $slug, $brand_id;
    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
        ];
    }
    public function resetInput()
    {
        $this->name = NULL;
        $this->slug = NULL;
        $this->brand_id = NULL;
    }

    public function storeBrand()
    {
        $validatedData = $this->validate();
         Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
        ]);
        session()->flash('message', 'Thêm Nhãn Hàng Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function editBrand(int $brand_id)
    {
        $this->brand_id = $brand_id;
        $brand = Brand::findOrFail($brand_id);
        $this->name = $brand->name;
        $this->slug = $brand->slug;
    }
    public function closeModal()
    {
        $this->resetInput();
    }
    public function openModal()
    {
        $this->resetInput();
    }
    public function updateBrand()
    {
        $validatedData = $this->validate();
        Brand::findOrFail($this->brand_id)->update([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
        ]);
        session()->flash('message', 'Chỉnh Sửa Nhãn Hàng Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function deleteBrand($brand_id)
    {
        $this->brand_id = $brand_id;
    }
    public function destroyBrand()
    {
        Brand::findOrFail($this->brand_id)->delete();
        session()->flash('message', 'Xóa Nhãn Hàng Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $brands = Brand::all();
        return view('livewire.admin.brand.index',['brands' => $brands]);
    }
}
