<div>
    @include('livewire.admin.brand.modal-form')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Danh sách nhãn hàng
                        <button class="btn btn-primary btn-sm text-white float-right" data-toggle="modal"
                            data-target="#addBrandModal">Thêm nhãn hàng</button>
                    </h4>
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
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên nhãn hàng</th>
                                <th>Đường dẫn</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td>
                                        <button wire:click="editBrand({{ $brand->id }})" data-toggle="modal"
                                            data-target="#updateBrandModal"class="btn btn-outline-success">Chỉnh
                                            Sửa</button>
                                        <button wire:click="deleteBrand({{ $brand->id }})" data-toggle="modal"
                                            data-target="#deleteBrandModal" class="btn btn-outline-danger">Xóa</button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Not brand found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addBrandModal').modal('hide');
            $('#updateBrandModal').modal('hide');
            $('#deleteBrandModal').modal('hide');
        });
    </script>
@endpush
