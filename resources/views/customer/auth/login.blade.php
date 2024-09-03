@extends('layouts.customer')

@section('title', 'Đăng nhập')

@push('style')
    <style>
        .form-control {
            border-radius: 3px;
        }
    </style>
@endpush
@section('content')
    <section class="vh-100 mt-5">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="{{ route('cus.post_login') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Đăng nhập bằng</p>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="mdi mdi-google"></i>
                            </button>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">Hoặc</p>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Email </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control form-control-lg" placeholder="Nhập địa chỉ email" />
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" />
                                <label class="form-check-label" for="remember">
                                    Ghi nhớ tôi
                                </label>
                            </div>
                            <a href="{{route('cus.passowrd-request')}}" class="text-body">Quên mật khẩu?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg float-end"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                            <p class="small fw-bold mb-0">Bạn chưa có tài khoản ? <a href="{{ route('cus.register') }}"
                                    class="link-danger">Đăng ký</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
