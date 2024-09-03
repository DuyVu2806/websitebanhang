@extends('layouts.customer')

@section('title', 'Quên mật khẩu')

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
                <form action="{{route(cus.post-passowrd-request)}}" method="post"></form>
                <div class="mb-3">
                    <label for="">Địa chỉ Email</label>
                    <input type="email" class="form-control" name="email" value="{{old('email')}}">
                    @error('email')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-info">Gửi email mail xác nhận</button>
            </div>
        </div>
    </section>
@endsection
