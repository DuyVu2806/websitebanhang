@extends('layouts.customer')

@section('title', 'Sản Phẩm')
@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <form action="{{ route('cus.searchByImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <button class="btn btn-outline-success" type="submit">Gửi</button>
            </form>
        </div>
    </section>

@endsection
