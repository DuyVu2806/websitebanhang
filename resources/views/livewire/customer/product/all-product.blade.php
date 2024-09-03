<div>
    <div class="float-start">
        <div class="container1">
            <input type="text" wire:model='keyword' class="input" required="" placeholder="Nhập Từ Khóa..."
                wire:keydown.enter="performSearch">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                    <title>Tìm Kiếm</title>
                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none"
                        stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                        stroke-width="32" d="M338.29 338.29L448 448"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="float-end dropdown">
        <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mdi mdi-filter"></span>Giá tiền
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li>
                <a class="dropdown-item" wire:click="sortProducts('high-to-low')" style="cursor: pointer" >Từ cao đến thấp</a>
            </li>
            <li>
                <a class="dropdown-item" wire:click="sortProducts('low-to-high')" style="cursor: pointer" >Từ thấp đến cao</a>
            </li>
        </ul>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="ms-1 p-4 border shadow">
                <div class="">
                    <h4>Danh mục</h4>
                </div>
                <div class="">
                    @foreach ($categories as $cateItem)
                        <label class="d-block">
                            <input type="checkbox" wire:model="cateInputs" value="{{ $cateItem->id }}">
                            {{ $cateItem->name }}
                        </label>
                    @endforeach

                </div>
            </div>
            <div class=" ms-1 mt-3 p-4 border shadow">
                <div class="">
                    <h4>Nhãn hàng</h4>
                </div>
                <div class="">
                    @foreach ($brands as $brandItem)
                        <label class="d-block">
                            <input type="checkbox" wire:model="brandInputs" value="{{ $brandItem->id }}">
                            {{ $brandItem->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="row g-1">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('cus.product_detail', ['product_slug' => $product->slug]) }}">
                            <div class="card p-3 shadow border">
                                <div class="text-center">
                                    <img src="{{ $product->image }}" width="200px">
                                </div>
                                <div class="product-details">
                                    <div class="truncate-text">
                                        <span data-toggle="tooltip"
                                            title="{{ $product->name }}">{{ $product->name }}</span>
                                    </div>
                                    <span class="font-weight-bold d-block">
                                        {{ number_format($product->price) }} VNĐ
                                    </span>

                                    <div class="buttons d-flex flex-row">
                                        @if ($this->isInWishlist($product->id))
                                            <a class="heart_wishlist" style="cursor: pointer;"
                                                wire:click='addToWishlist({{ $product->id }})'>
                                                <span class="mdi mdi-heart"></span>
                                            </a>
                                        @else
                                            <a class="heart" style="cursor: pointer;"
                                                wire:click='addToWishlist({{ $product->id }})'>
                                                <span class="mdi mdi-heart-outline"></span>
                                            </a>
                                        @endif


                                        <button style="font-size: 9pt" class="btn btn-success cart-button btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            Thêm vào giỏ
                                        </button>
                                    </div>
                                    <div class="weight">
                                        <small>{{ $product->small_description }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                @empty
                    <h3>Không có sản phẩm nào</h3>
                @endforelse
            </div>
        </div>
    </div>
</div>
