<div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary"
                    style="margin-right: 7.5px">Quay
                    Lại</a>
            </div>
            <br>
            <br>
            <form wire:submit.prevent="createQty"  enctype="multipart/form-data">
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
                <div class="row">
                    <div class="form-group col">
                        <label for="">Vận chuyển</label>
                        <input type="text" class="form-control" wire:model.defer="transportation">
                    </div>
                </div>
                <hr style="margin-left: -1.81rem; margin-right: -1.81rem">
                <h4 class="mb-4 col">Thông tin sản phẩm</h4>
                <button type="button" class="btn btn-outline-primary" wire:click="addNewProduct">Thêm sản phẩm
                    mới</button>

                @foreach ($productFields as $index => $product)
                    <div class="border p-3 mt-3">
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Mã sản phẩm</label>
                                <input type="text" wire:model.defer="productFields.{{ $index }}.product_code"
                                    class="form-control" wire:change="findProductName({{ $index }})">
                            </div>
                            <div class="form-group col">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" wire:model.defer="productFields.{{ $index }}.name"
                                    class="form-control">
                            </div>
                            <div class="form-group col">
                                <label for="">Nhập số lượng</label>
                                <input type="text" wire:model.defer="productFields.{{ $index }}.quantity"
                                    class="form-control">
                            </div>
                            <div class="form-group col">
                                <label for="">Giá tiền</label>
                                <input type="text" wire:model.defer="productFields.{{ $index }}.price"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group col">
                            <label for="">Phân loại sản phẩm</label><br>
                            @if ($showClassificationFields[$index])
                                <button wire:click="addNewClassification({{$index}})" class="btn btn-outline-primary mb-2">Thêm
                                    mới</button>
                                    <ul >
                                        @foreach ($productFields[$index]['productCollections'] as $item => $collection)
                                            <div class="row position-relative border p-3 mb-2">
                                                <div class="form-group col" wire:key="collection-{{ $item }}">
                                                    <label for="">Tên loại SP</label>
                                                    <input type="text"
                                                        wire:model.defer="productCollections.{{ $index }}.{{ $item }}.name_collection"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col">
                                                    <label for="">Số lượng</label>
                                                    <input type="text"
                                                        wire:model.defer="productCollections.{{ $index }}.{{ $item }}.quantity"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col">
                                                    <label for="">Giá tiền</label>
                                                    <input type="text"
                                                        wire:model.defer="productCollections.{{ $index }}.{{ $item }}.price"
                                                        class="form-control">
                                                </div>
                                                <button wire:click="removeClassification({{ $index }},{{ $item }})"
                                                    class="btn btn-danger btn-sm position-absolute"
                                                    style="top: 0;right: 0">
                                                    Xóa
                                                </button>
                                            </div>
                                        @endforeach
                                    </ul>
                            @endif

                        </div>
                    </div>
                @endforeach


                <button type="submit" class="btn btn-lg btn-outline-primary float-right"
                    style="margin-right: 7.5px">XÁC
                    NHẬN</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
@endpush
