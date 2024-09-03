@extends('layouts.customer')

@section('title', 'Thanh Toán')

@push('style')
    <style>
        .card,
        .btn,
        .form-control,
        .modal-content {
            border-radius: 5px;
        }

        .toggle {
            display: inline-block;
        }

        .toggle {
            position: relative;
            height: 100px;
            width: 100px;
        }

        .toggle .button {
            transition: all 300ms cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 15px 25px -4px rgba(0, 0, 0, 0.1), inset 0 -3px 4px -1px rgba(0, 0, 0, 0.2), 0 -10px 15px -1px rgba(255, 255, 255, 0.6), inset 0 3px 4px -1px rgba(255, 255, 255, 0.2), inset 0 0 5px 1px rgba(255, 255, 255, 0.8), inset 0 20px 30px 0 rgba(255, 255, 255, 0.2);
            border-radius: 68.8px;
            position: absolute;
            background: #eaeaea;
            margin-left: -34.4px;
            margin-top: -34.4px;
            display: block;
            height: 26.8px;
            width: 26.8px;
            left: 32%;
            top: 34%;
        }

        .toggle .button:hover{
            background: #e1b7b7;
        }
        .truncate-text {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('content')
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <livewire:customer.checkout.checkout-view />
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
    </script>
@endpush
