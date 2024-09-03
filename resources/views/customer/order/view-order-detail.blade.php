@extends('layouts.customer')

@section('title', 'Chi tiết đơn hàng')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .product-name {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .modal-content,
        .form-control {
            border-radius: 2px;
        }

        .start-33 {
            left: 33.33%;
        }

        .start-66 {
            left: 66.67%;
        }
        .progress{
            background-color: #994848;
        }
    </style>
@endpush
@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }}); min-height:100vh;">
        </div>
        <div class="container">
            @php
                $total = 0;
            @endphp
            <div class="card-body shadow">
                <div class="col-md-12">
                    <h4>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Chi tiết đơn hàng của tôi
                        <a href="{{ route('cus.order') }}" class="btn btn-sm btn-info float-end">Quay Lại</a>
                    </h4>
                </div>
                <hr>
                <div class="col-12 border shadow mb-5 mt-3 p-3">
                    @php
                        $textColor = [];
                        switch ($order->status_message) {
                            case '0':
                                $width = 0;
                                $textColor = ['0' => 'success', '1' => 'secondary', '2' => 'secondary', '3' => 'secondary'];
                                $textMessage = "Đặt Hàng Thành Công"; 
                                break;
                            case '1':
                                $width = 33.33;
                                $textColor = ['0' => 'success', '1' => 'success', '2' => 'secondary', '3' => 'secondary'];
                                $textMessage = "Đang Xác Nhận"; 
                                break;
                            case '2':
                                $width = 66.67;
                                $textColor = ['0' => 'success', '1' => 'success', '2' => 'success', '3' => 'secondary'];
                                $textMessage = "Đang Giao Hàng"; 
                                break;
                            case '3':
                                $width = 100;
                                $textColor = ['0' => 'success', '1' => 'success', '2' => 'success', '3' => 'success'];
                                $textMessage = "Giao Hàng Thành Công"; 
                                break;
                            case '4':
                                $width = 100;
                                $textColor = ['0' => 'danger', '1' => 'danger', '2' => 'danger', '3' => 'danger'];
                                $textMessage = "Đã Hủy Đơn Hàng"; 
                                break;
                        }
                    @endphp
                    <div class="position-relative m-4 mb-5" style="margin: 0 30px">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $width }}%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Đặt Hàng Thành Công"
                            class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-{{ $textColor[0] }} rounded-pill"
                            style="width: 2rem; height:2rem;">
                            0
                        </div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Chờ Xác Nhận"
                            class="position-absolute top-0 start-33 translate-middle btn btn-sm btn-{{ $textColor[1] }} rounded-pill"
                            style="width: 2rem; height:2rem;">
                            1
                        </div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Đang Giao Hàng"
                            class="position-absolute top-0 start-66 translate-middle btn btn-sm btn-{{ $textColor[2] }} rounded-pill"
                            style="width: 2rem; height:2rem;">
                            2
                        </div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" title="Giao Hàng Thành Công"
                            class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-{{ $textColor[3] }} rounded-pill"
                            style="width: 2rem; height:2rem;">
                            3
                        </div>
                    </div>
                    <p class="d-flex justify-content-end">Trạng thái đơn hàng: <span class="text-{{$textColor[0]}}"> {{$textMessage}}</span> </p> 
                </div>
                <div class="row ml-1 mr-1">
                    <div class="col-md-5">
                        <h4 class="mb-3 font-weight-bold">Thông tin cá nhân</h4>
                        <div class="mb-3">
                            <label for="" style="font-size: 14pt">Họ & tên:</label> <span
                                class="h5 text-dark">{{ $order->fullname }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" style="font-size: 14pt">Email:</label> <span
                                class="h5 text-dark">{{ $order->email }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" style="font-size: 14pt">Số điện thoại:</label> <span
                                class="h5 text-dark">{{ $order->phone }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" style="font-size: 14pt">Địa chỉ:</label> <span
                                class="h5 text-dark">{{ $order->address }}, {{ $order->wards }}, {{ $order->district }},
                                {{ $order->province }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="font-weight-bold">Thông tin sản phẩm</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tên SP</th>
                                    <th>Số lượng</th>
                                    <th>Phân loại</th>
                                    <th class="text-center">Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItem as $item)
                                    <tr>
                                        <td class="product-name">
                                            {{ $item->product->name }}
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            @if ($item->product_collection_id)
                                                {{ $item->productCollection->name_collection }}
                                            @else
                                                Không có
                                            @endif

                                        </td>
                                        <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} &#8363;</td>
                                    </tr>
                                    @php
                                        $total += $item->quantity * $item->price;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3">Phí vận chuyển:</td>
                                    <td class="text-end">
                                        {{ number_format($order->total_price - $total, 0, ',', '.') }} &#8363;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Tổng cộng:</td>
                                    <td class="text-end">
                                        {{ number_format($order->total_price, 0, ',', '.') }} &#8363;
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
{{-- 
<td style="line-height: 100%">

    @if ($order->status_message == 3 && $item->rstatus == 0)
        <button type="button" class="btn btn-sm btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#ReviewModal-{{ $item->id }}">
            Đánh giá
        </button>
        
        <form role="form" action="" method="POST">
            @csrf
            <div class="modal fade" id="ReviewModal-{{ $item->id }}"
                tabindex="-1" aria-labelledby="ReviewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ReviewModalLabel">
                                Đánh giá sản phẩm
                            </h5>
                            <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="rateYo_{{ $item->id }}"
                                class="mb-2 rateYo">
                            </div>
                            <input type="hidden" name="rating"
                                id="rateYo_{{ $item->id }}_rating"
                                value="5">
                            <input type="hidden" name="product_id" id="product_id"
                                value={{ $item->product_id }}>
                            <div class="mb-2">
                                <label for="">Phân loại</label>
                                <input type="text" class="form-control"
                                    id="collection" name="collection"
                                    value="{{ $item->productCollection->name_collection }}">
                            </div>

                            <div class="mb-2">
                                <label for="">Tính năng nổi bật</label>
                                <input type="text" class="form-control"
                                    id="outstanding_feature"
                                    name="outstanding_feature">
                            </div>

                            <div class="mb-2">
                                <label for="">Bình luận</label>
                                <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button"
                                class="btn btn-primary evaluate-btn"
                                data-product-id="{{ $item->product_id }}"
                                data-id="{{ $item->id }}">Đánh giá</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    @else
        <h6 class="text-center text-success">Rated</h6>
    @endif
</td> --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function() {
            $('.rateYo').each(function() {
                var id = $(this).attr('id');
                $(this).rateYo({
                    rating: 5,
                    fullStar: true,
                }).on("rateyo.set", function(e, data) {
                    $('#' + id + '_rating').val(data.rating);
                });
            });
        });
        $(".evaluate-btn").click(function() {
            var rating = $(this).closest(".modal-content").find(".rateYo").rateYo("rating");
            var comment = $(this).closest(".modal-content").find(".modal-body #comment").val();
            var outstanding_feature = $(this).closest(".modal-content").find(
                ".modal-body #outstanding_feature").val();
            var collection = $(this).closest(".modal-content").find(".modal-body #collection")
                .val();
            var productId = $('#product_id').val();
            var id = $(this).data('id');
            var url = '{{ route('cus.review', ':id') }}';
            url = url.replace(':id', id);
            var dataToSend = {
                rating: rating,
                comment: comment,
                outstanding_feature: outstanding_feature,
                collection: collection,
                productId: productId
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: dataToSend,
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your message here',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#Modal-' + productId).modal('hide');
                        location.reload();
                    });
                }
            });
        });
    </script>
@endpush
