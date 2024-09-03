@extends('layouts.customer')

@section('title', 'Giỏ Hàng')

@push('style')
    <style>
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

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 25px;
            cursor: pointer;
        }

        .toggle-switch input[type="checkbox"] {
            display: none;
        }

        .toggle-switch-background {
            position: absolute;
            top: 13px;
            left: 28px;
            width: 100%;
            height: 100%;
            background-color: #ddddddbb;
            border-radius: 20px;
            box-shadow: inset 0 0 0 2px #cccccc00;
            transition: background-color 0.3s ease-in-out;
        }

        .toggle-switch-handle {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 13px;
            height: 13px;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .toggle-switch::before {
            content: "";
            position: absolute;
            top: -25px;
            right: -35px;
            font-size: 12px;
            font-weight: bold;
            color: #aaa;
            text-shadow: 1px 1px #fff;
            transition: color 0.3s ease-in-out;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-handle {
            transform: translateX(45px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02), 0 0 0 2px #0551c467;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background {
            background-color: #0551c467;
            box-shadow: inset 0 0 0 2px #b9d2f767;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch:before {
            content: "On";
            color: #0551c467;
            right: -15px;
        }

        .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background .toggle-switch-handle {
            transform: translateX(17px);
        }
    </style>
@endpush

@section('content')
    <section style="padding-top: 7rem;" >
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <livewire:customer.cart.cart-view />
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        window.addEventListener('message', event => {
            Swal.fire({
                position: 'center',
                icon: event.detail.type,
                title: event.detail.text,
                showConfirmButton: false,
                timer: 1500
            })
        });
        window.addEventListener('messageDelete', event => {
            Swal.fire({
                position: 'top-end',
                icon: event.detail.type,
                text: event.detail.text,
                showConfirmButton: false,
                toast: true,
                timer: 1200,
                timerProgressBar: true,
                width: 'auto',
                padding: '0.7em'
            })
        });
    </script>
@endpush
