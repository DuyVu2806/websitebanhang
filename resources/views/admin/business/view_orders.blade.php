@extends('layouts.admin')

@section('title', 'Đơn Hàng')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>Order</h3>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label for="">Lọc theo ngày đặt đơn</label>
                                <input type="date" name="date" value="{{ Request::get('date') ?? '' }}"
                                    class="custom-select">
                            </div>
                            <div class="col-md-3">
                                <label for="">Lọc theo trạng thái đơn</label>
                                <select name="status" class="custom-select">
                                    <option value=""> -->Chọn Trạng Thái<-- </option>
                                    <option value="0" {{ Request::get('status') == '0' ? 'selected' : '' }}>
                                        Đặt hàng thành công
                                    </option>
                                    <option value="1" {{ Request::get('status') == '1' ? 'selected' : '' }}>
                                        Đang xác thực
                                    </option>
                                    <option value="2" {{ Request::get('status') == '2' ? 'selected' : '' }}>
                                        Đang vận chuyển
                                    </option>
                                    <option value="3" {{ Request::get('status') == '3' ? 'selected' : '' }}>
                                        Giao hàng thành công
                                    </option>
                                    <option value="4" {{ Request::get('status') == '4' ? 'selected' : '' }}>
                                        Đơn hủy
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <br>
                                <button type="submit" class="btn btn-primary mt-2">Lọc</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-triped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tài khoản đặt hàng</th>
                                <th>Họ & Tên</th>
                                <th>Phương thức Đặt hàng</th>
                                <th>Ngày mua</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->customer->fullname }}</td>
                                    <td>{{ $item->fullname }}</td>
                                    <td>{{ $item->payment_mode }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $item->status_message }}</td>
                                    <td>
                                        <a href="{{ route('admin.business.view_order_detail', ['orderDetailId' => $item->id]) }}"
                                            class="btn btn-sm btn-info">Chi tiết</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Không có đơn hàng nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
