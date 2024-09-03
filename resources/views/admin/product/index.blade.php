@extends('layouts.admin')

@section('title', 'Sản Phẩm')

@push('style')
    <style>
        .card-body{
            min-height: calc(100vh - 63px);
        }
    </style>
@endpush

@section('content')
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.product.create') }}" class="btn btn-outline-primary">Thêm Mới SP</a>
                <a href="{{route('admin.product.create_qty')}}" class="btn btn-outline-info">Nhập Thêm SP</a>
            </div>
            <table class="table table-bordered table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>Đường dẫn</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Nhãn hàng</th>
                        <th>Số lượng </th>
                        <th>Giá tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $key => $product)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <th>{{ $product->product_code }}</th>
                            <th>{{ $product->name }}</th>
                            <th>{{ $product->slug }}</th>
                            <th>
                                <img src="{{ asset($product->image) }}" alt="">
                            </th>
                            <th>
                                @php
                                    if (isset($product->category->deleted_at)) {
                                        echo 'Không tồn tại';
                                    } else {
                                        echo $product->category->name;
                                    }
                                    
                                @endphp

                            </th>
                            <th>
                                @php
                                    if (isset($product->brand->deleted_at)) {
                                        echo 'Không tồn tại';
                                    } else {
                                        echo $product->brand->name;
                                    }
                                    
                                @endphp

                            </th>
                            <th>{{ $product->quantity }}</th>
                            <th>{{ $product->price }}</th>
                            <th>
                                <a href="{{ route('admin.product.update', ['id' => $product->id]) }}"
                                    class="btn btn-outline-info">Chỉnh sửa</a>
                                <a href="" class="btn btn-outline-danger">Xóa</a>
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="10">Không có sản phẩm.</th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
