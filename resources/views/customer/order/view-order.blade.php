@extends('layouts.customer')

@section('title', 'Đơn hàng')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .nav-tabs .nav-link {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .form-control,
        .card,
        .modal-content {
            border-radius: 3px;
        }
    </style>
@endpush
@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }}); min-height: 100vh;">
        </div>
        <div class="container">
            <ul class="nav nav-tabs nav-fill " id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                        role="tab" aria-controls="all" aria-selected="true">Tất Cả</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="success-tab" data-bs-toggle="tab" data-bs-target="#success" type="button"
                        role="tab" aria-controls="success" aria-selected="false">Đặt Hàng Thành Công</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="wait-tab" data-bs-toggle="tab" data-bs-target="#wait" type="button"
                        role="tab" aria-controls="wait" aria-selected="false">Chờ Xác Nhận</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tranport-tab" data-bs-toggle="tab" data-bs-target="#tranport"
                        type="button" role="tab" aria-controls="tranport" aria-selected="false">Đang Vận
                        Chuyển</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="successfully-tab" data-bs-toggle="tab" data-bs-target="#successfully"
                        type="button" role="tab" aria-controls="successfully" aria-selected="false">Hoàn Thành</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cancel-tab" data-bs-toggle="tab" data-bs-target="#cancel" type="button"
                        role="tab" aria-controls="cancel" aria-selected="false">Đã Hủy</button>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <input type="text" placeholder="Tìm kiếm đơn hàng..." class="form-control mt-2 mb-2">
                    @forelse ($orders as $item)
                        <div class="card border shadow mb-3">
                            <div class="position-relative">
                                @php
                                    $status;
                                    switch ($item->status_message) {
                                        case '0':
                                            $status = 'Đặt Hàng Thành Công';
                                            $style = 'text-success';
                                            break;
                                        case '1':
                                            $status = 'Xác Nhận Đơn Hàng';
                                            $style = 'text-info';
                                            break;
                                        case '2':
                                            $status = 'Đang Vận Chuyển';
                                            $style = 'text-info';
                                            break;
                                        case '3':
                                            $status = 'Giao Hàng Thành Công';
                                            $style = 'text-success';
                                            break;
                                        case '4':
                                            $status = 'Hủy Đơn Hàng';
                                            $style = 'text-danger';
                                            break;
                                    }
                                @endphp
                                <p class="{{ $style }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                                <span><a href="{{ route('cus.order_detail', ['id' => $item->id]) }}"
                                        class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi tiết</a></span>
                            </div>
                            <hr class="m-0 p-0">
                            @php
                                $key0 = 0;
                            @endphp
                            @foreach ($item->orderItem as $value)
                            @php
                                if ($value->rstatus == 1) {
                                    $key0++;
                                }
                            @endphp
                                <div class="row position-relative">
                                    <div class="col-1 m-3">
                                        <img src="{{ asset($value->product->image) }}" alt="" width="75px"
                                            height="75px">
                                    </div>
                                    <div class="col-10 my-3">
                                        <span class="text-dark">{{ $value->product->name }}</span><br>
                                        @if (isset($value->productCollection))
                                            <span>{{ $value->productCollection->name_collection }}</span><br>
                                        @endif
                                        
                                        <span class="text-dark">x{{ $value->quantity }}</span>
                                        <span class="position-absolute text-danger"
                                            style="top: 33%;right:3%">{{ number_format($value->price, 0, ',', '.') }}
                                            &#8363;</span>
                                    </div>
                                </div>
                                <hr class="m-0 p-0">
                            @endforeach
                            <hr>
                            <div class="mb-3">
                                <div class="float-end">
                                    @if ($item->status_message == 3 && $key0 != $item->orderItem->count())
                                        <button class="btn btn-outline-success me-5" data-bs-toggle="modal"
                                            data-bs-target="#ReviewModal-{{ $item->id }}">Đánh giá</button>

                                        <div class="modal fade" id="ReviewModal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="ReviewModalLabel" aria-hidden="true">
                                            <form enctype="multipart/form-data" action="{{route('cus.review0')}}" method="POST"
                                                data-id="{{ $item->id }}">
                                                @csrf
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
                                                            @foreach ($item->orderItem as $index)
                                                                <div id="product-review-{{ $item->id }}">
                                                                    <div class="row">
                                                                        <div class="col-1">
                                                                            <img src="{{ $index->product->image }}"
                                                                                alt="" width="40px">
                                                                        </div>
                                                                        <div class="col-10">
                                                                            <span>{{ $index->product->name }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <p>Chất lượng sản phẩm</p>
                                                                    <div id="rateYo_{{ $index->id }}" class=" rateYo">
                                                                    </div>
                                                                    <input type="hidden"
                                                                        name="product_reviews[{{ $index->id }}][order_item_id]"
                                                                        value="{{ $index->id }}">
                                                                    <input type="hidden"
                                                                        name="product_reviews[{{ $index->id }}][rating]"
                                                                        id="rateYo_{{ $index->id }}_rating"
                                                                        value="5">
                                                                    <div class="mb-2">
                                                                        <label for="">Phân loại</label>
                                                                        <input type="text" class="form-control"
                                                                            id="collection"
                                                                            name="product_reviews[{{ $index->id }}][name_collection]"
                                                                            value="{{ $index->productCollection->name_collection }}">
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <label for="">Tính năng nổi bật</label>
                                                                        <input type="text" class="form-control"
                                                                            id="outstanding_feature"
                                                                            name="product_reviews[{{ $index->id }}][outstanding_feature]">
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <label for="">Bình luận</label>
                                                                        <textarea name="product_reviews[{{ $index->id }}][comment]" id="comment" rows="3" class="form-control"></textarea>

                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary evaluate-btn"
                                                                data-id="{{ $item->id }}">Đánh
                                                                giá</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    <span class="ms-3 me-5 h5 text-danger">Thành tiền:
                                        {{ number_format($item->total_price, 0, ',', '.') }}
                                        &#8363;</span>
                                </div>

                            </div>


                        </div>
                    @empty
                        <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                            <div>
                                <img style="margin-left: 1.25em"
                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                    alt="" width="100px">
                                <p>Chưa có đơn hàng</p>
                            </div>

                        </div>
                    @endforelse

                </div>
                <div class="tab-pane fade" id="success" role="tabpanel" aria-labelledby="success-tab">
                    @forelse ($ordersSuccess as $item0)
                        <div class="card border shadow mb-3">
                            <div class="position-relative">
                                @php
                                    $status = 'Đặt Hàng Thành Công';
                                    $style = 'text-success';
                                @endphp
                                <p class="{{ $style }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                                <span><a href="{{ route('cus.order_detail', ['id' => $item0->id]) }}"
                                        class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi
                                        tiết</a></span>
                            </div>
                            <hr class="m-0 p-0">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($item0->orderItem as $value0)
                                @php
                                    $total += $value0->price * $value0->quantity;
                                @endphp
                                <div class="row position-relative">
                                    <div class="col-1 m-3">
                                        <img src="{{ asset($value0->product->image) }}" alt="" width="75px"
                                            height="75px">
                                    </div>
                                    <div class="col-10 my-3">
                                        <span class="text-dark">{{ $value0->product->name }}</span><br>
                                        @if (isset($value0->productCollection))
                                        <span>{{ $value0->productCollection->name_collection }}</span><br>
                                    @endif
                                        <span class="text-dark">x{{ $value0->quantity }}</span>
                                        <span class="position-absolute text-danger"
                                            style="top: 33%;right:3%">{{ number_format($value0->price, 0, ',', '.') }}
                                            &#8363;</span>
                                    </div>
                                </div>
                                <hr class="m-0 p-0">
                            @endforeach
                            <hr>
                            <div class="mb-3">
                                <div class="float-end">
                                    <span class="ms-3 me-5 h5 text-danger">Thành tiền:
                                        {{ number_format($item0->total_price, 0, ',', '.') }}
                                        &#8363;</span>
                                </div>

                            </div>

                        </div>
                    @empty
                        <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                            <div>
                                <img style="margin-left: 1.25em"
                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                    alt="" width="100px">
                                <p>Chưa có đơn hàng</p>
                            </div>

                        </div>
                    @endforelse
                </div>
                <div class="tab-pane fade" id="wait" role="tabpanel" aria-labelledby="wait-tab">
                    @forelse ($ordersWait as $item1)
                        <div class="card border shadow mb-3">
                            <div class="position-relative">
                                @php
                                    $status = 'Xác Nhận Đơn Hàng';
                                    $style = 'text-info';
                                @endphp
                                <p class="{{ $style }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                                <span><a href="{{ route('cus.order_detail', ['id' => $item1->id]) }}"
                                        class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi
                                        tiết</a></span>
                            </div>
                            <hr class="m-0 p-0">
                            @foreach ($item1->orderItem as $value1)
                                <div class="row position-relative">
                                    <div class="col-1 m-3">
                                        <img src="{{ asset($value1->product->image) }}" alt="" width="75px"
                                            height="75px">
                                    </div>
                                    <div class="col-10 my-3">
                                        <span class="text-dark">{{ $value1->product->name }}</span><br>
                                        @if (isset($value1->productCollection))
                                        <span>{{ $value1->productCollection->name_collection }}</span><br>
                                    @endif
                                        <span class="text-dark">x{{ $value1->quantity }}</span>
                                        <span class="position-absolute text-danger"
                                            style="top: 33%;right:3%">{{ number_format($value1->price, 0, ',', '.') }}
                                            &#8363;</span>
                                    </div>
                                </div>
                                <hr class="m-0 p-0">
                            @endforeach
                            <hr>
                            <div class="mb-3">
                                <div class="float-end">
                                    <span class="ms-3 me-5 h5 text-danger">Thành tiền:
                                        {{ number_format($item1->total_price, 0, ',', '.') }}
                                        &#8363;</span>
                                </div>

                            </div>


                        </div>
                    @empty
                        <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                            <div>
                                <img style="margin-left: 1.25em"
                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                    alt="" width="100px">
                                <p>Chưa có đơn hàng</p>
                            </div>

                        </div>

                    @endforelse
                </div>
                <div class="tab-pane fade" id="tranport" role="tabpanel" aria-labelledby="tranport-tab">
                    @forelse ($ordersTranpost as $item2)
                        <div class="card border shadow mb-3">
                            <div class="position-relative">
                                @php
                                    $status = 'Đang Vận Chuyển';
                                    $style = 'text-info';
                                @endphp
                                <p class="{{ $style }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                                <span><a href="{{ route('cus.order_detail', ['id' => $item2->id]) }}"
                                        class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi
                                        tiết</a></span>

                            </div>
                            <hr class="m-0 p-0">
                            @foreach ($item2->orderItem as $value)
                                <div class="row position-relative">
                                    <div class="col-1 m-3">
                                        <img src="{{ asset($value2->product->image) }}" alt="" width="75px"
                                            height="75px">
                                    </div>
                                    <div class="col-10 my-3">
                                        <span class="text-dark">{{ $value2->product->name }}</span><br>
                                        <span>{{ $value2->productCollection->name_collection }}</span><br>
                                        <span class="text-dark">x{{ $value2->quantity }}</span>
                                        <span class="position-absolute text-danger"
                                            style="top: 33%;right:3%">{{ number_format($value2->price, 0, ',', '.') }}
                                            &#8363;</span>
                                    </div>
                                </div>
                                <hr class="m-0 p-0">
                            @endforeach
                            <hr>
                            <div class="mb-3">
                                <div class="float-end">
                                    <span class="ms-3 me-5 h5 text-danger">Thành tiền:
                                        {{ number_format($item2->total_price, 0, ',', '.') }}
                                        &#8363;</span>
                                </div>

                            </div>


                        </div>
                    @empty
                        <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                            <div>
                                <img style="margin-left: 1.25em"
                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                    alt="" width="100px">
                                <p>Chưa có đơn hàng</p>
                            </div>

                        </div>
                    @endforelse
                </div>
                <div class="tab-pane fade" id="successfully" role="tabpanel" aria-labelledby="successfully-tab">
                    @forelse ($ordersSuccessfully as $item3)
                        <div class="card border shadow mb-3">
                            <div class="position-relative">
                                @php
                                    $status = 'Giao Hàng Thành Công';
                                    $style = 'text-success';
                                @endphp
                                <p class="{{ $style }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                                <span><a href="{{ route('cus.order_detail', ['id' => $item3->id]) }}"
                                        class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi
                                        tiết</a></span>

                            </div>
                            <hr class="m-0 p-0">
                            @php
                                $key3 = 0;
                            @endphp
                            @foreach ($item3->orderItem as $value3)
                                @php
                                    if ($value3->rstatus == 1) {
                                        $key3++;
                                    }
                                @endphp
                                <div class="row position-relative">
                                    <div class="col-1 m-3">
                                        <img src="{{ asset($value3->product->image) }}" alt="" width="75px"
                                            height="75px">
                                    </div>
                                    <div class="col-10 my-3">
                                        <span class="text-dark">{{ $value3->product->name }}</span><br>
                                        @if (isset($value3->productCollection))
                                        <span>{{ $value3->productCollection->name_collection }}</span><br>
                                    @endif
                                        <span class="text-dark">x{{ $value3->quantity }}</span>
                                        <span class="position-absolute text-danger"
                                            style="top: 33%;right:3%">{{ number_format($value3->price, 0, ',', '.') }}
                                            &#8363;</span>
                                    </div>
                                </div>
                                <hr class="m-0 p-0">
                            @endforeach
                            <hr>
                            <div class="mb-3">
                                <div class="float-end">
                                    @if ($item3->orderItem->count() != $key3)
                                        <button class="btn btn-outline-success me-5" data-bs-toggle="modal"
                                            data-bs-target="#ReviewSuccessModal-{{ $item3->id }}">Đánh giá</button>
                                        <div class="modal fade" id="ReviewSuccessModal-{{ $item3->id }}"
                                            tabindex="-1" aria-labelledby="ReviewSuccessModalLabel" aria-hidden="true">
                                            <form enctype="multipart/form-data" action="{{ route('cus.review0') }}"
                                                method="POST" data-id="{{ $item3->id }}">
                                                @csrf
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
                                                            @foreach ($item3->orderItem as $index3)
                                                                <div id="product-review-{{ $item3->id }}">
                                                                    <div class="row">
                                                                        <div class="col-1">
                                                                            <img src="{{ $index3->product->image }}"
                                                                                alt="" width="40px">
                                                                        </div>
                                                                        <div class="col-10">
                                                                            <span>{{ $index3->product->name }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <p>Chất lượng sản phẩm</p>
                                                                    <div id="rateYo_{{ $index3->id }}" class=" rateYo">
                                                                    </div>
                                                                    <input type="hidden"
                                                                        name="product_reviews[{{ $index3->id }}][order_item_id]"
                                                                        value="{{ $index3->id }}">
                                                                    <input type="hidden"
                                                                        name="product_reviews[{{ $index3->id }}][rating]"
                                                                        id="rateYo_{{ $index3->id }}_rating"
                                                                        value="5">
                                                                    <div class="mb-2">
                                                                        <label for="">Phân loại</label>
                                                                        <input type="text" class="form-control"
                                                                            id="collection"
                                                                            name="product_reviews[{{ $index3->id }}][name_collection]"
                                                                            value="{{ $index3->productCollection->name_collection }}">
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <label for="">Tính năng nổi bật</label>
                                                                        <input type="text" class="form-control"
                                                                            id="outstanding_feature"
                                                                            name="product_reviews[{{ $index3->id }}][outstanding_feature]">
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <label for="">Bình luận</label>
                                                                        <textarea name="product_reviews[{{ $index3->id }}][comment]" id="comment" rows="3" class="form-control"></textarea>

                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary evaluate-btn"
                                                                data-id="{{ $item3->id }}">Đánh
                                                                giá</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    <span class="ms-3 me-5 h5 text-danger">
                                        Thành tiền:
                                        {{ number_format($item3->total_price, 0, ',', '.') }}&#8363;
                                    </span>
                                </div>


                            </div>

                        </div>
                    @empty
                        <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                            <div>
                                <img style="margin-left: 1.25em"
                                    src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                    alt="" width="100px">
                                <p>Chưa có đơn hàng</p>
                            </div>

                        </div>
                    @endforelse
                </div>
            </div>
            <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                @forelse ($ordersCancel as $item4)
                    <div class="card border shadow mb-3">
                        <div class="position-relative">
                            @php
                                $status = 'Hủy Đơn Hàng';
                                $style = 'text-danger';
                            @endphp
                            <p class="{{ $style4 }} text-uppercase float-end me-3 mt-3">{{ $status }}</p>
                            <span><a href="{{ route('cus.order_detail', ['id' => $item4->id]) }}"
                                    class="float-end me-3 btn btn-sm" style="margin-top: 0.8rem">Xem chi
                                    tiết</a></span>
                        </div>
                        <hr class="m-0 p-0">
                        @foreach ($item4->orderItem as $value4)
                            <div class="row position-relative">
                                <div class="col-1 m-3">
                                    <img src="{{ asset($value4->product->image) }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-10 my-3">
                                    <span class="text-dark">{{ $value4->product->name }}</span><br>
                                    @if (isset($value4->productCollection))
                                    <span>{{ $value4->productCollection->name_collection }}</span><br>
                                @endif
                                    <span class="text-dark">x{{ $value4->quantity }}</span>
                                    <span class="position-absolute text-danger"
                                        style="top: 33%;right:3%">{{ number_format($value4->price, 0, ',', '.') }}
                                        &#8363;</span>
                                </div>
                            </div>
                            <hr class="m-0 p-0">
                        @endforeach
                        <hr>
                        <div class="mb-3">
                            <div class="float-end">
                                <span class="ms-3 me-5 h5 text-danger">Thành tiền:
                                    {{ number_format($item->total_price, 0, ',', '.') }}
                                    &#8363;</span>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="border d-flex align-items-center justify-content-center" style="min-height: 100vh">
                        <div>
                            <img style="margin-left: 1.25em"
                                src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/5fafbb923393b712b96488590b8f781f.png"
                                alt="" width="100px">
                            <p>Chưa có đơn hàng</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        </div>

    </section>

@endsection
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
    </script>
@endpush
