{{-- modal Add Cate --}}
<div class="modal fade" wire:ignore.self id="addCateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm Danh Mục SP</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="storeCate" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Tên danh mục SP</label>
                        <input type="text" wire:model.defer="name" class="form-control">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Đường dẫn</label>
                        <input type="text" wire:model.defer="slug" class="form-control">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Hình ảnh</label><br>
                        <input type="file" wire:model="image">
                        @error('image')
                            <br><small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if ($imageTemporaryUrl)
                            <img class="mt-2" height="80px" width="80px" src="{{ $imageTemporaryUrl }}" alt="Selected Image">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="">Tiêu đề ban đầu</label>
                        <input type="text" wire:model.defer="meta_title" class="form-control">
                        @error('meta_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Mô tả</label>
                        <input type="text" wire:model.defer="description" class="form-control">
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary"
                        data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- modal Edit Cate --}}

<div class="modal fade" wire:ignore.self id="updateCateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh Sửa Danh Mục SP</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="updateCate" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Tên Danh mục SP</label>
                        <input type="text" wire:model.defer="name" class="form-control">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Đường dẫn</label>
                        <input type="text" wire:model.defer="slug" class="form-control">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Hình ảnh</label><br>
                        <input type="file" wire:model.defer="image">
                        @error('image')
                            <br><small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if ($imageTemporaryUrl)
                            <br><img class="mt-2" height="80px" width="80px" src="{{ $imageTemporaryUrl }}" alt="Selected Image">
                        @else
                            <br><img class="mt-2" height="80px" width="80px" src="{{ asset($image) }}" alt="Selected Image">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="">Tiêu đề ban đầu</label>
                        <input type="text" wire:model.defer="meta_title" class="form-control">
                        @error('meta_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Mô tả</label>
                        <input type="text" wire:model.defer="description" class="form-control">
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary"
                        data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal DeleteCate --}}
<div wire:ignore.self class="modal fade" id="deleteCateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Loại SP</h1>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div wire:loading class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                </div>
                <span class="visually-hidden">Loading...</span>
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent="destroyCate">
                    <div class="modal-body">
                        <h4>Bạn có chắc chắn muốn xóa danh mục này</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary"
                            data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
