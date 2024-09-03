@push('style')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endpush
<div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary"
                    style="margin-right: 7.5px">Quay
                    Lại</a>
            </div>
            @if (session()->has('message'))
                <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        text: '{{ session('message') }}',
                        showConfirmButton: false,
                        toast: true,
                        timer: 1200,
                        timerProgressBar: true,
                        width: 'auto',
                        padding: '0.7em'
                    })
                </script>
            @endif
            <br>
            <br>
            <form wire:submit.prevent="createProduct" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-4 col">Thông tin phiếu nhập hàng</h4>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Thủ Kho</label>
                        <input type="text" wire:model.defer="storekeeper" class="form-control">
                        @error('storekeeper')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="">Người ghi nhận</label>
                        <input type="text" wire:model.defer="receiving_clerk" class="form-control" readonly>
                        @error('receiving_clerk')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Nhà cung cấp</label>
                        <input type="text" wire:model.defer="supplier" class="form-control">
                        @error('supplier')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="">Tổng tiền hàng</label>
                        <input type="text" wire:model.defer="total_price" class="form-control">
                        @error('total_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <hr style="margin-left: -1.81rem; margin-right: -1.81rem">
                <h4 class="mb-4 col">Thông tin sản phẩm</h4>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Mã sản phẩm</label>
                        <input type="number" wire:model.defer="product_code" class="form-control">
                        @error('product_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Tên sản phẩm</label>
                        <input type="text" wire:model.defer="name" class="form-control">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group col">
                    <label for="">Đường dẫn</label>
                    <input type="text" wire:model.defer="slug" class="form-control">
                    @error('slug')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">Danh mục</label>
                        <select wire:model.defer="category_id" class="form-control">
                            <option value="" selected> >>Choose a category<< </option>
                                    @forelse ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                            <option value="">No Category</option>
                            @endforelse
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="">Nhãn hàng</label>
                        <select wire:model.defer="brand_id" class="form-control">
                            <option value="" selected> >>Choose a brand<< </option>
                                    @forelse ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @empty
                            <option value="">No Brand</option>
                            @endforelse
                        </select>
                        @error('brand_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="">Vận chuyển</label>
                        <input type="text" wire:model.defer="transportation" class="form-control">
                        @error('transportation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group col-6">
                        <label for="">
                            <input class="ml-1" type="checkbox" wire:model='is_trending'
                                style="transform: scale(1.5)"> Xu hướng
                        </label>
                    </div>
                    <div class="form-group col-6">
                        <label for="">
                            <input class="ml-1" type="checkbox" wire:model='is_new' style="transform: scale(1.5)">
                            Hàng mới
                        </label>
                    </div>
                </div>

                <div class="form-group col">
                    <label for="">Hình ảnh</label><br>
                    <input type="file" wire:model.defer="image"><br>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    @if ($imageTemporaryUrl)
                        <img class="mt-2" height="80px" width="80px" src="{{ $imageTemporaryUrl }}"
                            alt="Selected Image">
                    @endif
                </div>
                <div class="form-group col">
                    <label for="">Các hình ảnh liên quan</label><br>
                    <input type="file" multiple wire:model.defer="images">
                </div>
                <div class="form-group">
                    <label for="" style="margin-left: 7.5px">Phân loại của sản phẩm
                        <input class="ml-1" wire:model="showClassificationFields" type="checkbox"
                            style="transform: scale(1.5)">
                    </label>
                    <div id="classificationFields" wire:loading.class="hidden"
                        class="{{ $showClassificationFields ? '' : 'hidden' }}">
                        <button wire:click="addClassificationRow" type="button" style="margin-left: 7.5px "
                            class="btn btn-sm btn-outline-info mb-3">Thêm</button>
                        <div class="row" id="collectionform">
                            @foreach ($classificationRows as $index => $row)
                                <div class="row col-4 mb-2">
                                    <div class="card-body shadow position-relative">
                                        <button wire:click="removeClassificationRow({{ $index }})"
                                            type="button" class="btn btn-sm btn-danger position-absolute"
                                            style="top: 0;right:0">
                                            Xóa
                                        </button>
                                        <div class="form-group col-12">
                                            <label for="">Tên loại SP</label>
                                            <input type="text"
                                                wire:model.defer="classificationRows.{{ $index }}.name_collection"
                                                class="form-control">
                                            @error("classificationRows.{$index}.name_collection")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Số lượng</label>
                                            <input type="text"
                                                wire:model.defer="classificationRows.{{ $index }}.quantity_collection"
                                                class="form-control">
                                            @error("classificationRows.{$index}.quantity_collection")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">Giá tiền</label>
                                            <input type="text"
                                                wire:model.defer="classificationRows.{{ $index }}.price_collection"
                                                class="form-control">
                                            @error("classificationRows.{$index}.price_collection")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Số lượng </label>
                        <input type="number" wire:model.defer="quantity" class="form-control">
                        @error('quantity')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Giá nhập vào </label>
                        <input type="number" wire:model.defer="original_price" class="form-control">
                        @error('original_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Giá Bán</label>
                        <input type="number" wire:model.defer="price" class="form-control">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Chiều cao (cm)</label>
                        <input type="number" wire:model.defer="height" max="200" class="form-control">
                        @error('height')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Cân nặng (gram)</label>
                        <input type="number" wire:model.defer="weight" max="1600000" class="form-control">
                        @error('weight')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Chiều rộng (cm)</label>
                        <input type="number" wire:model.defer="width" max="200" class="form-control">
                        @error('width')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">CHiều dài (cm)</label>
                        <input type="number" wire:model.defer="length" max="200" class="form-control">
                        @error('length')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group col">
                    <label for="">Mô tả ngắn</label>
                    <textarea class="form-control" wire:model.defer="small_description" cols="30" rows="5"></textarea>
                    @error('small_description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @php
                    $quillStyles = [
                        'min-height' => '500px',
                    ];
                @endphp
                <div class="form-group col" wire:ignore>
                    <label for="">Mô tả chi tiết</label>
                    <livewire:quill :value="$description" :quillStyles="$quillStyles" wire:model="description" />

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror


                </div>


                <button type="submit" class="btn btn-lg btn-outline-primary float-right"
                    style="margin-right: 7.5px">XÁC
                    NHẬN</button>
            </form>

        </div>
    </div>
</div>
