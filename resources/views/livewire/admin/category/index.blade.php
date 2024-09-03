<div>
    @push('style')
        <style>
            .checkbox-input {
                clip: rect(0 0 0 0);
                -webkit-clip-path: inset(100%);
                clip-path: inset(100%);
                height: 1px;
                overflow: hidden;
                position: absolute;
                white-space: nowrap;
                width: 1px;
            }

            .checkbox-input:checked+.checkbox-tile {
                border-color: #ff2222;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                color: #ff2222;
            }

            .checkbox-input:checked+.checkbox-tile:before {
                transform: scale(1);
                opacity: 1;
                background-color: #ff2222;
                border-color: #ff2222;
            }

            .checkbox-input:checked+.checkbox-tile .checkbox-icon .mdi,
            .checkbox-input:checked+.checkbox-tile .checkbox-label {
                color: #ff2222;
            }

            .checkbox-input:focus+.checkbox-tile {
                border-color: #ff2222;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
            }

            .checkbox-input:focus+.checkbox-tile:before {
                transform: scale(1);
                opacity: 1;
            }

            .checkbox-tile {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 3rem;
                min-height: 1.8rem;
                border-radius: 0.5rem;
                border: 2px solid #b5bfd9;
                background-color: #fff;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                transition: 0.15s ease;
                cursor: pointer;
                position: relative;
            }

            .checkbox-tile:before {
                content: "";
                position: absolute;
                display: block;
                width: 0.45rem;
                height: 0.45rem;
                border: 2px solid #b5bfd9;
                background-color: #fff;
                border-radius: 50%;
                top: 0.25rem;
                left: 0.25rem;
                opacity: 0;
                transform: scale(0);
                transition: 0.25s ease;
            }

            .checkbox-tile:hover {
                border-color: #ff2222;
            }

            .checkbox-icon .mdi:hover {
                color: #ff2222;
            }

            .checkbox-tile:hover:before {
                transform: scale(1);
                opacity: 1;
            }

            .checkbox-icon {
                transition: 0.375s ease;
                color: #494949;
            }

            .checkbox-icon .mdi {
                font-size: 1rem;
                color: #696969
            }

            .checkbox-label {
                color: #707070;
                transition: 0.375s ease;
                text-align: center;
            }
        </style>
    @endpush

    @include('livewire.admin.category.modal-form')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Danh sách danh mục
                        <button class="btn btn-primary btn-sm text-white float-right" data-toggle="modal"
                            data-target="#addCateModal">Thêm danh mục SP</button>
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
                    <label class="checkbox-wrapper float-right">
                        <input class="checkbox-input" type="checkbox">
                        <span class="checkbox-tile">
                            <span class="checkbox-icon">
                                <span class="mdi mdi-trash-can-outline"></span>
                            </span>
                        </span>
                    </label>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên loại</th>
                                <th>Đường dẫn</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề ban đầu</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <img src="{{ asset($category->image) }}" alt="">
                                    </td>
                                    <td>{{ $category->meta_title }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <button wire:click="editCate({{ $category->id }})" data-toggle="modal"
                                            data-target="#updateCateModal"class="btn btn-outline-success">Chỉnh
                                            Sửa</button>
                                        <button wire:click="deleteCate({{ $category->id }})" data-toggle="modal"
                                            data-target="#deleteCateModal" class="btn btn-outline-danger">Xóa</button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Not Category found</td>
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
            $('#addCateModal').modal('hide');
            $('#updateCateModal').modal('hide');
            $('#deleteCateModal').modal('hide');
        });
    </script>
@endpush
