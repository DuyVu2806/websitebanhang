@extends('layouts.customer')

@section('title', 'Sản Phẩm')

@push('style')
    <style>
        .row {
            --bs-gutter-x: 0.5rem !important;
        }

        .modal-content {
            border-radius: 5px;
        }

        svg {
            width: 4.5rem;
        }

        .rating__background {
            fill: #ecff72;
            stroke: red;
            stroke-width: 1;
            height: 100%;
            width: 100%;
        }

        .rating__value {
            fill: #FFB94B;
            height: 100%;
        }

        .buttonFunc {
            outline: none;
            cursor: pointer;
            border: 0;
            font-size: .875rem;
            font-weight: 300;
            line-height: 1;
            letter-spacing: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color .1s cubic-bezier(.4, 0, .6, 1);
            border: 1px solid rgba(0, 0, 0, .09);
            border-radius: 2px;
            background: transparent;
            color: rgba(0, 0, 0, .8);
            width: 32px;
            height: 32px;
        }

        .valueQty {
            width: 50px;
            height: 32px;
            border-left: 0;
            border-right: 0;
            font-size: 16px;
            font-weight: 400;
            box-sizing: border-box;
            text-align: center;
            cursor: text;
            border-radius: 0;
            -webkit-appearance: none;
        }

        .truncate-text {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .checkbox-input {
            clip: rect(0 0 0 0);
            -webkit-clip-path: inset(100%);
            clip-path: inset(100%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;

        }

        .checkbox-input:checked+.checkbox-tile {
            border-color: #ff2222;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            color: #ff2222;
        }

        .checkbox-input:checked+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
            background-color: #ff2222;
            border-color: #ff2222;
        }

        .checkbox-input:checked+.checkbox-tile .checkbox-icon .mdi,
        .checkbox-input:checked+.checkbox-tile .checkbox-label {
            color: #ff2222;
        }

        .checkbox-input:focus+.checkbox-tile {
            border-color: #ff2222;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
        }

        .checkbox-input:focus+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-tile,
        .unstock {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* width: 3rem; */
            min-height: 1.8rem;
            border-radius: 0.5rem;
            border: 2px solid #b5bfd9;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: 0.15s ease;
            cursor: pointer;
            position: relative;
            padding: 10px;
        }

        .checkbox-tile:before,
        .unstock:before {
            content: "";
            position: absolute;
            display: block;
            width: 0.45rem;
            height: 0.45rem;
            border: 2px solid #b5bfd9;
            background-color: #fff;
            border-radius: 50%;
            top: 0.25rem;
            left: 0.25rem;
            opacity: 0;
            transform: scale(0);
            transition: 0.25s ease;
        }

        .checkbox-tile:hover {
            border-color: #ff2222;
        }

        .checkbox-icon .mdi:hover {
            color: #ff2222;
        }

        .checkbox-tile:hover:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-icon {
            transition: 0.375s ease;
            color: #494949;
        }

        .checkbox-icon .mdi {
            font-size: 1rem;
            color: #696969
        }

        .checkbox-label {
            color: #707070;
            transition: 0.375s ease;
            text-align: center;
        }

        .checkbox-input:disabled+.checkbox-tile {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
        }

        .swiper-slide img {
            /* display: block; */
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }

        .swiper {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .mySwiper2 {
            height: 60%;
            width: 100%;
        }

        .mySwiper {
            height: 10%;
            box-sizing: border-box;

            padding: 5px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
            border: 1px solid #ee0404;
        }

        .weight {
            margin-top: -65px;
            transition: all 0.5s;
        }

        .weight small {

            color: #e2dede;
        }

        .buttons {
            padding: 0px;
            /* background-color: #dad1d14f; */
            border-radius: 4px;
            position: relative;
            margin-top: 5px;
            opacity: 0;
            transition: all 0.8s;
        }

        .cart-button {
            height: 45px
        }

        .cart-button:focus {
            box-shadow: none
        }

        .heart {
            position: relative;
            height: 50px;
            width: 50px;
            margin-right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 11px;
            font-size: 30px;
            transition: 0.2s ease-in-out;
            overflow: hidden;
        }

        .heart:hover {
            color: #ff0000;
        }

        .cart-button.clicked span.dot {
            animation: item 0.3s ease-in forwards
        }

        @keyframes item {
            0% {
                opacity: 1;
                top: 30%;
                left: 30%
            }

            25% {
                opacity: 1;
                left: 26%;
                top: 0%
            }

            50% {
                opacity: 1;
                left: 23%;
                top: -22%
            }

            75% {
                opacity: 1;
                left: 19%;
                top: -18%
            }

            100% {
                opacity: 1;
                left: 14%;
                top: 28%
            }
        }

        .card:hover .buttons {
            opacity: 1;
        }

        .card:hover .weight {
            margin-top: 10px;
        }

        .card:hover {
            transform: scale(1.04);
            z-index: 2;
            overflow: hidden;
        }

        .radio-button-container {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .radio-button {
            display: inline-block;
            position: relative;
            cursor: pointer;
            border: 1px solid #FFB94B;
            border-radius: 2px
        }

        .radio-button__input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-button__label {
            display: inline-block;
            /* padding-left: 30px; */
            padding: 8px 30px;
            position: relative;
            font-size: 15px;
            color: #f9dfb5;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .radio-button__custom {
            position: absolute;
            top: 23%;
            left: 7%;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #f9dfb5;
            transition: all 0.3s ease;
        }

        .radio-button__input:checked+.radio-button__label .radio-button__custom {
            background-color: #FFB94B;
            border-color: transparent;
            transform: scale(0.8);
            box-shadow: 0 0 18px #FFB94B80;
        }

        .radio-button__input:checked+.radio-button__label {
            color: #FFB94B;
        }

        .radio-button__label:hover .radio-button__custom {
            transform: scale(1.2);
            border-color: #FFB94B;
            box-shadow: 0 0 20px #FFB94B80;
        }
    </style>
@endpush

@section('content')
    <livewire:customer.product.view-detail :product="$product" :review="$review" :reviewcount="$reviewcount" :listReplyComment="$listReplyComment"
        :orderProductBuy="$orderProductBuy" />
@endsection
@push('scripts')
@endpush
