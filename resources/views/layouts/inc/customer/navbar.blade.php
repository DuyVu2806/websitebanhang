<nav class="navbar navbar-expand-lg navbar-light fixed-top py-5 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container"><a class="navbar-brand" href=""><img src="" height="34" alt="logo" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon">
            </span></button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-lg-center align-items-start">
                <li class="nav-item px-3 px-xl-3">
                    <a class="nav-link fw-medium" href="{{ route('cus.home') }}">Trang chủ</a>
                </li>
                <li class="nav-item px-3 px-xl-3">
                    <a class="nav-link fw-medium" href="{{ route('cus.product_page') }}">Sản phẩm</a>
                </li>
                <li class="nav-item px-3 px-xl-3">
                    <a class="nav-link fw-medium" href="{{ route('cus.contact') }}">Phản hồi</a>
                </li>
                <li class="nav-item px-3 px-xl-3">
                    <a class="nav-link fw-medium" href="#">Về chúng tôi</a>
                </li>
                <li class="nav-item px-3 px-xl-3 position-relative">
                    <a class="nav-link fw-medium" href="{{ route('cus.cart') }}">
                        Giỏ hàng
                        <span class="position-absolute"
                            style="top: 0; right: 2%; border: 1px solid #dad1d1cf; border-radius: 50%;padding: 0px 0.4rem"><livewire:customer.cart.cart-count></span>
                    </a>
                </li>
                @if (Auth::guard('cus')->check())
                    <li class="nav-item dropdown px-3 px-lg-3">
                        @php
                            $name = Auth::guard('cus')->user()->fullname;
                            $name_parts = explode(' ', $name);
                            $last_two_parts = array_slice($name_parts, count($name_parts) - 2);
                            $last_two = implode(' ', $last_two_parts);
                        @endphp
                        <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">{{ $last_two }}</a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius:0.3rem;"
                            aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('cus.profile')}}">Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="{{ route('cus.order') }}">Đơn hàng</a></li>
                            <li><a class="dropdown-item" href="#">Yêu thích</a></li>
                            <li><a class="dropdown-item" href="{{ route('cus.logout') }}">Đăng xuất</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item px-3 px-xl-3">
                        <a class="nav-link fw-medium" href="{{ route('cus.login') }}">Đăng nhập</a>
                    </li>
                    <li class="nav-item px-3 px-xl-3">
                        <a class="btn btn-outline-warning order-1 order-lg-0 fw-medium"
                            href="{{ route('cus.register') }}">Đăng ký</a>
                    </li>
                @endif


            </ul>
        </div>
    </div>
</nav>
