@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>
                Thông tin chi tiết đơn hàng
                <a href="{{ route('admin.business.view_orders') }}" class="btn btn-info btn-sm float-right">Quay lại</a>
                {{-- <a href="{{ url('admin/invoice/' . $order->id . '/generate') }}"
                    class="btn btn-primary btn-sm float-end mx-1 text-light">Download Invoice</a>
                <a href="{{ url('admin/invoice/' . $order->id) }}" target="_blank"
                    class="btn btn-warning btn-sm float-end mx-1 text-light">View Invoice</a> --}}
            </h3>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <hr>
                    <h6>Mã số đơn: <span>{{ $order->id }}</span></h6>
                    <h6>Ngày đặt đơn: <span>{{ $order->created_at }}</span></h6>
                    <h6>Phương thức thanh toán: <span>{{ $order->payment_mode }}</span></h6>
                    @if ($order->status_message === 'cancelled')
                    @endif

                    @switch($order->status_message)
                        @case('cancelled')
                            <button class="btn btn-outline-danger text-uppercase w-100" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ $order->status_message }}</button>
                        @break

                        @case('delivered')
                            <button class="btn btn-outline-success text-uppercase w-100">{{ $order->status_message }}</button>
                        @break

                        @default
                            <button class="btn btn-outline-success text-uppercase w-100" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ $order->status_message }}</button>
                        @break
                    @endswitch

                    {{-- Start modal status_message --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ url('/admin/orders/' . $order->id) }}" method="POST" role="form">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Status Message</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="min-height: 150px">
                                        <select class="form-select" name="status_message">
                                            <option value="in progress"
                                                {{ $order->status_message == 'in progress' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="pending"
                                                {{ $order->status_message == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="delivered"
                                                {{ $order->status_message == 'delivered' ? 'selected' : '' }}>Delivery
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->status_message == 'cancelled' ? 'selected' : '' }}>Cancelled
                                            </option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End modal status_message --}}
                </div>

                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <hr>
                    <h6>Họ & tên: <span>{{ $order->fullname }}</span></h6>
                    <h6>Địa chỉ email: <span>{{ $order->email }}</span></h6>
                    <h6>Số điện thoại: <span>{{ $order->phone }}</span></h6>
                    <h6>Địa chỉ: <span>{{ $order->address }}, {{ $order->wards }}, {{ $order->district }},
                            {{ $order->province }}</span></h6>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-triped mt-3">
        <thead>
            <tr class="text-center">
                <th class="text-center" width='5%'>STT</th>
                <th>Hình Ảnh</th>
                <th>Sản phẩm</th>
                <th>Phân loại</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($order->orderItem as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center"><img src="{{ asset($item->product->image) }}" alt="" height="50px" width="50px"></td>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        @if ($item->product_collection_id)
                            {{ $item->productCollection->name_collection }}
                        @else
                            Không có
                        @endif
                    </td>
                    <td class="text-right">
                        {{ number_format($item->price, 0, ',', '.') }} &#8363;
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{ number_format($item->quantity * $item->price, 0, ',', '.') }} &#8363;
                    </td>
                    @php
                        $total += $item->quantity * $item->price;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="6">Phí vận chuyển: </td>
                <td colspan="1" class="text-right">{{ number_format($order->total_price - $total, 0, ',', '.') }} &#8363;</td>
            </tr>
            <tr class="table-active">
                <td colspan="6">Tổng cộng: </td>
                <td colspan="1" class="text-right">{{ number_format($order->total_price, 0, ',', '.') }} &#8363;</td>
            </tr>
        </tbody>
    </table>
@endsection
