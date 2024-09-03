@extends('layouts.customer')

@section('title', 'Sản Phẩm')

@push('style')
    <style>
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
        .heart_wishlist {
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
            color: #ff0000;
        }

        .heart_wishlist:hover {
            color: #14183E;
        }


        .cart-button.clicked span.dot {
            animation: item 0.2s ease-in forwards
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

        .truncate-text {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .container1 {
            position: relative;
            --size-button: 40px;
            color: #feb1b1;
        }

        .input {
            padding-left: var(--size-button);
            height: var(--size-button);
            font-size: 15px;
            border: none;
            color: #000000;
            outline: none;
            width: var(--size-button);
            transition: all ease 0.3s;
            background-color: #FFF1DA;
            border-radius: 50px;
            cursor: pointer;
        }

        .input:focus,
        .input:not(:invalid) {
            width: 200px;
            cursor: text;
            
        }

        .input:focus+.icon,
        .input:not(:invalid)+.icon {
            pointer-events: all;
            cursor: pointer;
        }

        .container1 .icon {
            position: absolute;
            width: var(--size-button);
            height: var(--size-button);
            top: 0;
            left: 0;
            padding: 8px;
            pointer-events: none;
        }

        .container1 .icon svg {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush
@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <livewire:customer.product.all-product />
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const cartButtons = document.querySelectorAll('.cart-button');
            cartButtons.forEach(button => {
                button.addEventListener('click', cartClick);
            });

            function cartClick() {
                let button = this;
                button.classList.add('clicked');
            }
        });
        window.addEventListener('message', event => {
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
