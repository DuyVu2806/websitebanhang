@extends('layouts.customer')

@section('title', 'Đăng ký')

@push('style')
    <style>
        .form-control{
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <section class="vh-100 mt-5">
        <div class="container h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100 shadow py-5 border">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="{{ route('cus.post_register') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h3 class="mb-3">Đăng ký</h3>
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Email </label>
                            <input type="email" name="email" value="{{old('email')}}" class="form-control form-control-lg"
                                placeholder="Nhập địa chỉ email" />
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Họ và tên</label>
                            <input type="text" name="fullname" value="{{old('fullname')}}" class="form-control form-control-lg"
                                placeholder="Nhập họ và tên" />
                            @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror                        
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Số điện thoại</label>
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control form-control-lg"
                                placeholder="Nhập số điện thoại" />
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label me-3" for="">Giới tính </label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="1" name="gender" checked>
                                <label class="form-check-label" for="gender">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="2" name="gender">
                                <label class="form-check-label" for="gender">Nữ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="3" name="gender">
                                <label class="form-check-label" for="gender">Khác</label>
                            </div>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="">Nhập mật khẩu</label>
                            <input type="password" name="password"  class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="">Nhập lại mật khẩu</label>
                            <input type="password" name="password_confirmation"  class="form-control form-control-lg"
                                placeholder="Nhập lại mật khẩu" />
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg float-end"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng ký</button>
                            <p class="small fw-bold mb-0">Bạn đã có tài khoản? <a
                                    href="{{ route('cus.login') }}" class="link-danger">Đăng nhập</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- <section class="vh-100 mt-5">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="{{ route('cus.post_register') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">Or</p>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Email address</label>
                            <input type="email" name="email" value="{{old('email')}}" class="form-control form-control-lg"
                                placeholder="Enter a valid email address" />
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Full name</label>
                            <input type="text" name="fullname" value="{{old('fullname')}}" class="form-control form-control-lg"
                                placeholder="Enter a valid full name" />
                            @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror                        
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Phone</label>
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control form-control-lg"
                                placeholder="Enter a valid number phone" />
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="">Password</label>
                            <input type="password" name="password"  class="form-control form-control-lg"
                                placeholder="Enter password" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Do have an account? <a
                                    href="{{ route('cus.login') }}" class="link-danger">login</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section> --}}
