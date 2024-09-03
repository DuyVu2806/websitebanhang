@extends('layouts.customer')

@section('title', 'Trang chủ')

@push('style')
    <style>
        .truncate-text {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        swiper-container {
            width: 660px;
            height: 485px;
        }

        .swiper-cube .swiper-cube-shadow::before {
            background: none !important;
        }

        swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }
    </style>
@endpush

@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end">
                    <swiper-container class="mySwiper" effect="cube" grab-cursor="true" cube-effect-shadow="false"
                        cube-effect-slide-shadows="false" cube-effect-shadow-offset="20" cube-effect-shadow-scale="0.94"
                        loop="true" autoplay-delay="2500" autoplay-disable-on-interaction="false">
                        <swiper-slide>
                            <img class="" style="width: 660px; height: 485px;"
                                src="{{ asset('customer/images/hero-img.png') }}" />
                        </swiper-slide>
                        <swiper-slide>
                            <img class="" style="width: 660px; height: 485px;"
                                src="{{ asset('customer/images/hero2-img.png') }}" />
                        </swiper-slide>
                        <swiper-slide>
                            <img class="" style="width: 660px; height: 485px;"
                                src="{{ asset('customer/images/hero3-img.png') }}" />
                        </swiper-slide>
                        <swiper-slide>
                            <img class="" style="width: 660px; height: 485px;"
                                src="{{ asset('customer/images/hero4-img.png') }}" />
                        </swiper-slide>
                    </swiper-container>
                </div>
                <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
                    <h4 class="fw-bold text-danger mb-3">Nơi mua sắp trực tuyến nhanh chóng và uy tín</h4>
                    <h1 class="hero-title">Chọn Lựa</h1>
                    <h1 class="hero-title">Không Giới Hạn, Sáng Tạo </h1>
                    <h1 class="hero-title">Theo Ý Thích</h1>
                    <p class="mb-4 fw-medium">Khám Phá Cửa Hàng Trực Tuyến - Chọn Lựa Vô Hạn, Sáng Tạo Theo Ý Thích Của Bạn.
                        Từ Thời Trang Đến Đồ Trang Sức, Tất Cả Đều Có Mặt Tại Đây. Hãy Khám Phá Ngay!<br
                            class="d-none d-xl-block" /><br class="d-none d-xl-block" /></p>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pt-md-6" id="destination">
        <div class="container">
            <div class="mb-7 text-center">
                <h5 class="text-secondary">Top Bán Chạy Nhất</h5>
                <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Những Sản Phẩm Tốt Nhất</h3>
            </div>
            <div class="row">
                @foreach ($productSelling as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card overflow-hidden shadow">
                            <img class="card-img-top" src="{{ $item->image }}" />
                            <div class="card-body py-4 px-3">
                                <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                                    <h4 class="text-secondary fw-medium truncate-text">
                                        <a href="{{route('cus.product_detail', ['product_slug' => $item->slug])}}" class="link-900 text-decoration-none stretched-link" data-toggle="tooltip"
                                            title="{{ $item->name }}">
                                            {{ $item->name }}
                                        </a>
                                    </h4>
                                    <span class="fs-1 fw-medium">{{ number_format($item->price) }} VNĐ</span>
                                </div>
                                <div class="d-flex align-items-center float-end">
                                    <i class="fa-brands fa-opencart text-danger"></i>&nbsp;&nbsp;&nbsp;
                                    <span class="fs-0 fw-medium">Mua Ngay</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="pt-5 pt-md-6" id="destination">
        <div class="container">
            <div class="mb-7 text-center">
                <h5 class="text-secondary">Danh Mục</h5>
                <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Những Danh Mục Sản Phẩm</h3>
            </div>
            <div class="row">
                @foreach ($categories as $category)
                    @php
                        $queryParams = ['category[0]' => $category->id];
                        $url = route('cus.product_page') . '?' . http_build_query($queryParams);
                    @endphp
                    <div class="col-md-3 mb-4">
                        <div class="card overflow-hidden shadow">
                            <img class="card-img-top" src="{{ $category->image }}" width="408px" height="408" />
                            <div class="card-body py-4 px-3">
                                <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                                    <h4 class="text-secondary fw-medium truncate-text">
                                        <a href="{{$url}}" class="link-900 text-decoration-none stretched-link" data-toggle="tooltip"
                                            title="{{ $category->name }}">
                                            {{ $category->name }}
                                        </a>
                                    </h4>
                                    {{-- <span class="fs-1 fw-medium">{{ number_format($category->price) }} VNĐ</span> --}}
                                </div>
                                <div class="d-flex align-items-center float-end">
                                    <span class="mdi mdi-plus-box text-danger"></span>&nbsp;&nbsp;&nbsp;
                                    <span class="fs-0 fw-medium">Xem ngay</span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="pt-5" id="service">
        <div class="container">
            <div class="mb-7 text-center">
                <h5 class="text-secondary">Danh mục</h5>
                <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Các Dịch Vụ Của Chúng Tôi</h3>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 mb-6">
                    <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                        <div class="card-body p-xxl-5 p-4"> <img src="{{ asset('customer/images/icon1.png') }}"
                                width="75" alt="Service" />
                            <h5 class="mb-3">Giao Hàng Nhanh Chóng</h5>
                            <p class="mb-0 fw-medium">Mua Sắm Ngay, Nhận Hàng Nhanh Chóng và An Toàn Tận Tay.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-6">
                    <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                        <div class="card-body p-xxl-5 p-4"> <img src="{{ asset('customer/images/icon2.png') }}"
                                width="75" alt="Service" />
                            <h5 class="mb-3">Đánh Giá Sản Phẩm</h5>
                            <p class="mb-0 fw-medium">Đánh Giá Từ Khách Hàng Thật: Khám Phá Sản Phẩm Qua Kinh Nghiệm Thực.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-6">
                    <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                        <div class="card-body p-xxl-5 p-4"> <img src="{{ asset('customer/images/icon3.png') }}"
                                width="75" alt="Service" />
                            <h5 class="mb-3">Thanh Toán An Toàn</h5>
                            <p class="mb-0 fw-medium">Thanh Toán An Toàn và Tiện Lợi: Bảo Mật Thông Tin Của Bạn.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-6">
                    <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                        <div class="card-body p-xxl-5 p-4"> <img src="{{ asset('customer/images/icon4.png') }}"
                                width="75" alt="Service" />
                            <h5 class="mb-3">Hỗ trợ khách hàng</h5>
                            <p class="mb-0 fw-medium">Hỗ Trợ Khách Hàng 24/7: Luôn Sẵn Sàng Đáp Ứng Mọi Yêu Cầu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <img src="http://127.0.0.1:8000/storage/product/64e8d60060d80.jpg" alt=""
            id="image"> --}}
    </section>

@endsection
@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.5.2"></script>
    <script src="https://unpkg.com/@tensorflow-models/mobilenet@2.0.4" type="text/javascript"></script>
    <script>
        // Đường dẫn đến ảnh cần phân loại
        const imageUrl = 'http://www.simplilearn.com/ice9/free_resources_article_thumb/what_is_image_Processing.jpg';

        // Lấy tham chiếu đến phần tử HTML hình ảnh
        const imageElement = document.getElementById('imageElement');

        // Hàm phân loại hình ảnh
        async function classifyImage() {
            // Tải mô hình MobileNet
            // tf.setBackend('cpu');
            const model = await mobilenet.load();

            // Tải và hiển thị hình ảnh
            console.log(imageElement);
            const image = await tf.browser.fromPixels(imageElement);
            console.log(image);

            // Thực hiện phân loại
            const predictions = await model.classify(image);

            // Hiển thị kết quả phân loại
            console.log(predictions);
        }

        // Gọi hàm phân loại khi hình ảnh được tải
        imageElement.onload = classifyImage;
        imageElement.src = imageUrl;
    </script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.0.0/p5.min.js"></script>
    <script src="https://unpkg.com/ml5@latest/dist/ml5.min.js"></script>
    <script>
        // Initialize the Image Classifier method with MobileNet
        const classifier = ml5.imageClassifier('MobileNet', modelLoaded);

        // When the model is loaded
        function modelLoaded() {
            console.log('Model Loaded!');
        }

        // Make a prediction with a selected image
        classifier.classify(document.getElementById('image'), (err, results) => {
            console.log(results);
        });
    </script> --}}
@endpush
