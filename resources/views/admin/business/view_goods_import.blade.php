@extends('layouts.admin')

@section('title', 'Nhập hàng')

@push('style')
<style>
    .detail-item {
        /* display: block; */
        margin-bottom: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .detail-item span {
            display: block;
            margin-bottom: 5px;
        }

    .product-code {
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    .quantity,
    .price,
    .transportation {
        display: block;
        color: #666;
    }
</style>
@endpush
@section('content')

    <div class="card mt-2">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width='5%'>STT</th>
                        <th>Quản lý</th>
                        <th>NV nhập</th>
                        <th>Nhà cung cấp</th>
                        <th width='10%'>Tổng tiền nhập hàng</th>
                        <th width='30%'>Chi tiết mặt hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grn as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->storekeeper }}</td>
                            <td>{{ $item->receiving_clerk }}</td>
                            <td>{{ $item->supplier }}</td>
                            <td>{{ number_format($item->total_price) }} VNĐ</td>
                            <td>
                                <ul>
                                    @foreach ($item->details as $detail)
                                        <li>
                                            <div class="detail-item">
                                                <span class="product-code">Mã Sản phẩm: {{ $detail->product_code }}</span>
                                                <span class="quantity">Số lượng: {{ $detail->quantity }}</span>
                                                <span class="price">Giá nhập: {{ number_format($detail->original_price) }} VNĐ</span>
                                                <span class="price">Giá bán: {{ number_format($detail->price) }} VNĐ</span>
                                                <span class="transportation">Vận chuyển: {{ $detail->transportation }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Không có đơn nào</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
