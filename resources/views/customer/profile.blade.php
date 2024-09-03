@extends('layouts.customer')

@section('title', 'Thông tin cá nhân')

@push('style')
    <style>
        .card,
        .form-control {
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    hello

                </div>
                <div class="col-9 card shadow border">

                    <div class="title mt-2">
                        <h4 class="text-uppercase">Thông tin của tôi</h4>
                        <p>Quản lý thông tin tài khoản để bảo mật tài khoản</p>
                    </div>
                    <hr>
                    <div style="margin: 0 140px">
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-2">
                                <label class="col-form-label">Họ và tên</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="fullname"
                                    value="{{ auth()->guard('cus')->user()->fullname }}">
                            </div>
                        </div>
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-2">
                                <label class="col-form-label">Email</label>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" readonly name="email"
                                    value="{{ auth()->guard('cus')->user()->email }}">
                            </div>
                        </div>
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-2">
                                <label class="col-form-label">Số điện thoại</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="phone"
                                    value="{{ auth()->guard('cus')->user()->phone }}">
                            </div>
                        </div>
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-2">
                                <label class="col-form-label">Giới tính</label>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="1" name="gender" {{ auth()->guard('cus')->user()->gender == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="2" name="gender" {{ auth()->guard('cus')->user()->gender == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender">Nữ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="3" name="gender" {{ auth()->guard('cus')->user()->gender == 3 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender">Khác</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mb-3">Gửi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
