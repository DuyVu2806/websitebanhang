<div>
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
            <div class=" card-registration card-registration-2 shadow border" style="border-radius: 15px;">
                <div class="card-body p-0" style="margin: 0 0.9em; ">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="p-5">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h1 class="fw-bold mb-0 text-black">Giỏ Hàng</h1>
                                    <h6 class="mb-0 text-muted">{{ $carts->count() }} Sản phẩm</h6>
                                </div>
                                <hr class="my-4">
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @forelse ($carts as $cartItem)
                                    <div class="card-body shadow position-relative" style="min-height: 25vh">
                                        <div class="position-absolute" style="top: 0;right: 0">
                                            <a  class="text-danger"
                                                wire:click='removeCartItem({{ $cartItem->id }})'
                                                style="font-size: 30px;cursor: pointer">
                                                <span class="mdi mdi-close-octagon-outline"></span>
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="col-3  my-auto">
                                                <img src="{{ $cartItem->product->image }}" class="img-fluid rounded-0"
                                                    alt="Cotton T-shirt">
                                            </div>
                                            <div class="col-4  my-auto">
                                                <h6 class="prodname">
                                                    {{ $cartItem->product->name }}

                                                </h6>
                                                @if ($cartItem->productCollection)
                                                    <div>
                                                        {{ $cartItem->productCollection->name_collection }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-3 d-flex my-auto">
                                                <button class="buttonFunc " wire:click='minusQty({{ $cartItem->id }})'>
                                                    <svg viewBox="0 0 10 10">
                                                        <polygon
                                                            points="4.5 4.5 3.5 4.5 0 4.5 0 5.5 3.5 5.5 4.5 5.5 10 5.5 10 4.5">
                                                        </polygon>
                                                    </svg>
                                                </button>
                                                <input class="buttonFunc valueQty" type="text" role="spinbutton"
                                                    value="{{ $cartItem->quantity }}" aria-valuenow="1">
                                                <button class="buttonFunc " wire:click='plusQty({{ $cartItem->id }})'>
                                                    <svg viewBox="0 0 10 10">
                                                        <polygon
                                                            points="10 4.5 5.5 4.5 5.5 0 4.5 0 4.5 4.5 0 4.5 0 5.5 4.5 5.5 4.5 10 5.5 10 5.5 5.5 10 5.5">
                                                        </polygon>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="col-1  my-auto checkItem-sm">
                                                <label for="checkItem">
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" wire:model="cartCollec.{{ $cartItem['id'] }}.checkItem"
                                                        wire:click="updateSelections({{ $cartItem['id'] }})"
                                                        name="checkItem" value="1">
                                                        <div class="toggle-switch-background">
                                                            <div class="toggle-switch-handle"></div>
                                                        </div>
                                                    </label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        if ($cartItem->checkItem == 1) {
                                            if ($cartItem->productCollection) {
                                                $totalPrice += $cartItem->productCollection->price * $cartItem->quantity;
                                            } else {
                                                $totalPrice += $cartItem->product->price * $cartItem->quantity;
                                            }
                                        }
                                        
                                    @endphp

                                @empty
                                    <h4>Không có sản phẩm nào</h4>
                                @endforelse
                                <div class="pt-5">
                                    <h6 class="mb-0"><a href="{{ route('cus.product_page') }}" class="text-info">Back
                                            to shop</a>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 bg-grey"
                            style="border-top-right-radius: 16px;border-bottom-right-radius: 16px;">
                            <div class="p-5">
                                <h3 class="fw-bold mb-5 mt-2 pt-1">Tổng cộng</h3>
                                <hr class="my-4">
                                <div class="d-flex justify-content-between mb-5">
                                    <h5 class="text-uppercase">Tổng số tiền</h5>
                                    <h5>{{ number_format($totalPrice, 0, ',', '.') }}&#8363;</h5>
                                </div>
                                @if ($cartCount != 0)
                                    <a class="btn btn-lg btn-warning btn-block w-100 text-light"
                                        href="{{route('cus.checkout')}}">Thanh Toán</a>
                                @else
                                    <a class="btn btn-lg btn-warning btn-block w-100 text-light disabled"
                                        href="">Thanh Toán</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
