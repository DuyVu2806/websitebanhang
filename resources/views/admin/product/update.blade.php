@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Sản Phẩm')

@section('content')
    <livewire:admin.product.update :product="$product" />
@endsection
