<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Livewire;

class Index extends Component
{
    use WithFileUploads;

    public $image, $name, $slug, $cate_id, $meta_title, $description;
    protected $imageTemporaryUrl;

    public function updatedImage($value)
    {
        if ($value) {
            $this->imageTemporaryUrl = $value->temporaryUrl();
            Session::put('temporaryImage', $this->imageTemporaryUrl);
        }
    }
    function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'image' => 'required',
            'meta_title' => 'required|string',
            'description' => 'required|string'
        ];
    }
    public function resetInput()
    {
        $this->name = NULL;
        $this->slug = NULL;
        $this->image = NULL;
        $this->meta_title = NULL;
        $this->description = NULL;
        $this->cate_id = NULL;
        Session::forget('temporaryImage');
    }
    public function closeModal()
    {
        $this->resetInput();
    }
    public function openModal()
    {
        $this->resetInput();
    }
    public function storeCate()
    {
        $this->updatedImage($this->image);
        $validatedData = $this->validate();
        if ($this->image) {
            $uploadPath = 'public/category';
            $file = $this->image;
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->storeAs($uploadPath, $filename);
            $finalImagePathName = 'storage/category/' . $filename;

            Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
                'image' => $finalImagePathName,
                'meta_title' => $this->meta_title,
                'description' => $this->description
            ]);
        }

        session()->flash('message', 'Thêm Loại SP Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editCate(int $cate_id)
    {
        $this->cate_id = $cate_id;
        $cate = Category::findOrFail($cate_id);
        $this->name = $cate->name;
        $this->slug = $cate->slug;
        $this->image = $cate->image;
        $this->meta_title = $cate->meta_title;
        $this->description = $cate->description;
    }
    public function updateCate()
    {
        if (!is_string($this->image)) {
            $this->updatedImage($this->image);
        }
        $validatedData = $this->validate();
        $updateCate = Category::findOrFail($this->cate_id);
        if ($this->image != $updateCate->image) {
            if ($updateCate->image) {
                Storage::delete('public/category/' . basename($updateCate->image));
            }
            $uploadPath = 'public/category';
            $file = $this->image;
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->storeAs($uploadPath, $filename);
            $finalImagePathName = 'storage/category/' . $filename;
            $updateCate->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'image' => $finalImagePathName,
                'meta_title' => $this->meta_title,
                'description' => $this->description
            ]);
        } else {
            $updateCate->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'meta_title' => $this->meta_title,
                'description' => $this->description
            ]);
        }
        session()->flash('message', 'Chỉnh Sửa Loại SP Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function deleteCate($cate_id)
    {
        $this->cate_id = $cate_id;
    }
    public function destroyCate()
    {
        $cate = Category::findOrFail($this->cate_id);
        Storage::delete('public/category/' . basename($cate->image));
        $cate->delete();
        session()->flash('message', 'Xóa Loại SP Thành Công');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function mount()
    {
        if (Session::has('temporaryImage')) {
            $this->imageTemporaryUrl = Session::get('temporaryImage');
        }
        
    }
    public function render()
    {
        $categories  = Category::all();
        
        return view('livewire.admin.category.index', ['categories' => $categories, 'imageTemporaryUrl' => $this->imageTemporaryUrl]);
    }
}
