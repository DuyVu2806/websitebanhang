<div>
    <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url({{ asset('customer/images/hero-bg.svg') }});">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-5 " wire:ignore>
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                        class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset($product->image) }}" />
                            </div>
                            @foreach ($product->productImage as $index1)
                                <div class="swiper-slide">
                                    <img src="{{ asset($index1->image) }}" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next" style="color: #ada393"></div>
                        <div class="swiper-button-prev" style="color: #ada393"></div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset($product->image) }}" />
                            </div>
                            @foreach ($product->productImage as $index2)
                                <div class="swiper-slide">
                                    <img src="{{ asset($index2->image) }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @php
                    $rating = $product->rating;
                    $starPercentage = ($rating / 5) * 100;
                @endphp
                <div class="col-7 ">
                    <div>
                        <h3 class="mb-3 mt-3 mb-2" style="font-size: 1.45rem">{{ $product->name }}</h3>
                        <div class="row mb-4">
                            <div class="rating col-2">
                                <span>{{ $rating }}/5</span>
                                <svg viewBox="0 0 1000 200">
                                    <defs>
                                        <polygon id="star"
                                            points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 " />
                                        <clipPath id="stars">
                                            <use xlink:href="#star" />
                                            <use xlink:href="#star" x="20%" />
                                            <use xlink:href="#star" x="40%" />
                                            <use xlink:href="#star" x="60%" />
                                            <use xlink:href="#star" x="80%" />
                                        </clipPath>
                                    </defs>
                                    <rect class='rating__background' clip-path="url(#stars)"></rect>
                                    <rect width="{{ $starPercentage }}%" class='rating__value' clip-path="url(#stars)">
                                    </rect>
                                </svg>
                            </div>
                            <div class="col-2" style="font-size: 0.875rem">{{ $reviewCount }} Đánh giá</div>
                            <div class="col-3" style="font-size: 0.875rem">{{ $orderProductBuy }} Đã bán</div>
                            <div class="col me-3 d-flex justify-content-end">
                                @if ($this->isInWishlist($product->id))
                                    <a wire:click='addToWishlist({{ $product->id }})' class="text-danger"
                                        style="cursor: pointer">
                                        <span class="mdi mdi-heart-outline"></span>
                                        Yêu thích
                                    </a>
                                @else
                                    <a wire:click='addToWishlist({{ $product->id }})' style="cursor: pointer">
                                        <span class="mdi mdi-heart-outline"></span>
                                        Yêu thích
                                    </a>
                                @endif


                            </div>
                        </div>
                        <div class="d-flex justify-content-start " style="margin: 60px 0 ">
                            <span style="font-size: 2.075rem;">Giá Tiền:
                                @if ($selectedCollectionId)
                                    {{ number_format($this->collectionPrice(), 0, ',', '.') }}&#8363;
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }}&#8363;
                                @endif
                            </span>
                        </div>
                        @if ($product->productCollection->count())
                            <div class="mb-4">
                                Phân loại:
                                @foreach ($product->productCollection as $index)
                                    @if ($index->quantity == 0)
                                        <label class="checkbox-wrapper float-right">
                                            <input class="checkbox-input" type="radio" name="collection" disabled>

                                            <span class="unstock">
                                                <span class="checkbox-icon">
                                                    {{ $index->name_collection }}
                                                </span>
                                            </span>
                                        </label>
                                    @else
                                        <label class="checkbox-wrapper float-right">
                                            <input class="checkbox-input" type="radio" name="collection"
                                                wire:model="selectedCollectionId" value="{{ $index->id }}">
                                            <span class="checkbox-tile">
                                                <span class="checkbox-icon">
                                                    {{ $index->name_collection }}
                                                </span>
                                            </span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-5 d-flex align-items-center">
                            <button class="buttonFunc " wire:click='minusQty'>
                                <svg viewBox="0 0 10 10">
                                    <polygon points="4.5 4.5 3.5 4.5 0 4.5 0 5.5 3.5 5.5 4.5 5.5 10 5.5 10 4.5">
                                    </polygon>
                                </svg>
                            </button>
                            <input class="buttonFunc valueQty" type="text" role="spinbutton" value="1"
                                aria-valuenow="1" wire:model='valueQty'>
                            <button class="buttonFunc " wire:click='plusQty'>
                                <svg viewBox="0 0 10 10">
                                    <polygon
                                        points="10 4.5 5.5 4.5 5.5 0 4.5 0 4.5 4.5 0 4.5 0 5.5 4.5 5.5 4.5 10 5.5 10 5.5 5.5 10 5.5">
                                    </polygon>
                                </svg>
                            </button>
                            <span class="ms-5">{{ $product->quantity }} sản phẩm có sẵn</span>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-outline-warning p-3 me-3" wire:click="addToCart">
                                <span class="mdi mdi-cart-plus">
                                </span>Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-danger " style="padding: 1rem 3.3rem">Mua ngay</button>
                        </div>

                    </div>
                </div>
            </div>
            <hr>
            <h3 class="text-uppercase">Chi tiết sản phẩm</h3>
            <p>Danh mục: Sản phẩm > {{ $product->category->name }}</p>
            <p>Kho hàng: Cần thơ</p>
            <h3 class="text-uppercase">Mô Tả Sản Phẩm</h3>
            <div>
                @if ($this->shouldShowDescriptionButtons())
                    @if (!$showFullDescription)
                        {!! substr($product->description, 0, 500) !!}...
                        <a wire:click="showFullDescription"
                            style="cursor: pointer; text-decoration-line: underline">Xem thêm</a>
                    @else
                        {!! $product->description !!}
                        <a class="float-center" wire:click="hideFullDescription"
                            style="cursor: pointer; text-decoration-line: underline">Rút gọn</a>
                    @endif
                @else
                    {!! $product->description !!}
                @endif
            </div>
            <hr>
            <h3 class="text-uppercase">Sản Phẩm Tương Tự</h3>
            <div class="swiper mySwiper3 mb-3" wire:ignore>
                <div class="swiper-wrapper">
                    @foreach ($similarProduct as $indexProduct)
                        <div class="swiper-slide">
                            <a
                                href="{{ route('cus.product_detail', ['product_slug' => $indexProduct['product']->slug]) }}">
                                <div class="card p-3 shadow border">
                                    <div class="text-center">
                                        <img src="{{ asset($indexProduct['product']->image) }}" width="200px">
                                    </div>
                                    <div class="product-details">
                                        <div class="truncate-text">
                                            <span data-toggle="tooltip"
                                                title="{{ $indexProduct['product']->name }}">{{ $indexProduct['product']->name }}</span>
                                        </div>
                                        <span class="font-weight-bold d-block">
                                            {{ number_format($indexProduct['product']->price) }} VNĐ
                                        </span>

                                        <div class="buttons d-flex flex-row">
                                            <a href="" class="heart">
                                                <span class="mdi mdi-heart-outline"></span></a>

                                            <button style="font-size: 9pt"
                                                class="btn btn-success cart-button btn-block">
                                                <i class="fa fa-shopping-cart"></i>
                                                Thêm vào giỏ
                                            </button>
                                        </div>
                                        <div class="weight">
                                            <small>{{ $indexProduct['product']->small_description }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <h3 class="text-uppercase mt-5">Đánh Giá Sản Phẩm</h3>
            <div class="border p-3">
                <div class="row">
                    <div class="col-3 row d-flex justify-content-center mb-5">
                        <div class="col-12 d-flex justify-content-center">
                            <span style="font-size: 1.875rem" class="text-primary">{{ $rating }} <span
                                    style="font-size: 1.125rem">Trên 5</span></span>

                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <svg viewBox="0 0 1000 200" style="width: 8.25rem">
                                <defs>
                                    <polygon id="star"
                                        points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 " />
                                    <clipPath id="stars">
                                        <use xlink:href="#star" />
                                        <use xlink:href="#star" x="20%" />
                                        <use xlink:href="#star" x="40%" />
                                        <use xlink:href="#star" x="60%" />
                                        <use xlink:href="#star" x="80%" />
                                    </clipPath>
                                </defs>
                                <rect class='rating__background' clip-path="url(#stars)"></rect>
                                <rect width="{{ $starPercentage }}%" class='rating__value' clip-path="url(#stars)">
                                </rect>
                            </svg>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="radio-button-container">
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio1" name="radio-group"
                                    checked wire:click="filterReviews(null)">
                                <label class="radio-button__label mb-0" for="radio1">
                                    <span class="radio-button__custom"></span>
                                    Tất cả ({{ $reviewCount }})
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio2" name="radio-group"
                                    wire:click="filterReviews(5)">
                                <label class="radio-button__label mb-0" for="radio2">
                                    <span class="radio-button__custom"></span>
                                    5 sao ({{ $this->countReviewsByRating(5) }})
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio3" name="radio-group"
                                    wire:click="filterReviews(4)">
                                <label class="radio-button__label mb-0" for="radio3">
                                    <span class="radio-button__custom"></span>
                                    4 Sao ({{ $this->countReviewsByRating(4) }})
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio4" name="radio-group"
                                    wire:click="filterReviews(3)">
                                <label class="radio-button__label mb-0" for="radio4">
                                    <span class="radio-button__custom"></span>
                                    3 Sao ({{ $this->countReviewsByRating(3) }})
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio5" name="radio-group"
                                    wire:click="filterReviews(2)">
                                <label class="radio-button__label mb-0" for="radio5">
                                    <span class="radio-button__custom"></span>
                                    2 Sao ({{ $this->countReviewsByRating(2) }})
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio6" name="radio-group"
                                    wire:click="filterReviews(1)">
                                <label class="radio-button__label mb-0" for="radio6">
                                    <span class="radio-button__custom"></span>
                                    1 Sao ({{ $this->countReviewsByRating(1) }})
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="headings d-flex justify-content-between align-items-center mb-3">
                    <h5>Tổng số đánh giá: {{ $reviewCount }}</h5>
                </div>

                @forelse ($review as $reviewItem)
                    <div class="p-3 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="user d-flex flex-row align-items-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                    width="30" class="user-img rounded-circle mr-2">
                                <span class="ms-1">
                                    <small class="font-weight-bold text-info">
                                        {{ $reviewItem->customer->fullname }}
                                    </small><br>
                                    <small class="font-weight-bold">
                                        @php
                                            $ratingReview = $reviewItem->rating;
                                            $starPercentageReview = ($ratingReview / 5) * 100;
                                        @endphp
                                        <svg viewBox="0 0 1000 200">
                                            <defs>
                                                <polygon id="star"
                                                    points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 " />
                                                <clipPath id="stars">
                                                    <use xlink:href="#star" />
                                                    <use xlink:href="#star" x="20%" />
                                                    <use xlink:href="#star" x="40%" />
                                                    <use xlink:href="#star" x="60%" />
                                                    <use xlink:href="#star" x="80%" />
                                                </clipPath>
                                            </defs>
                                            <rect class='rating__background' clip-path="url(#stars)"></rect>
                                            <rect width="{{ $starPercentageReview }}%" class='rating__value'
                                                clip-path="url(#stars)">
                                            </rect>
                                        </svg>
                                    </small>
                                </span>
                            </div>
                            <small>{{ now()->diffForHumans($reviewItem->created_at) }}</small>
                        </div>
                        <div class="action d-flex justify-content-between mt-2 align-items-center">
                            <div class="reply px-4">
                                <label style="font-size: 12pt">Phân loại:
                                    <span class="text-dark">{{ $reviewItem->collection }}</span>
                                </label><br>
                                <label style="font-size: 12pt">Tính năng nổi bật:
                                    <span class="text-dark">{{ $reviewItem->outstanding_feature }}</span>
                                </label><br>
                                <label>Bình luận:
                                    <span class="text-dark">{{ $reviewItem->comment }}</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    @foreach ($listReplyComment[$reviewItem->id] as $repItem)
                        @if ($repItem['review_id'] == $reviewItem->id)
                            <div class="p-3 mb-2" style="margin-left: 5em">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="user d-flex flex-row align-items-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            width="30" class="user-img rounded-circle mr-2">
                                        <span>
                                            <small class="font-weight-bold text-primary">{{ $repItem['name'] }}
                                            </small><br>
                                        </span>
                                    </div>
                                    <small>{{ now()->diffForHumans($repItem['created_at']) }}</small>
                                </div>
                                <div class="action d-flex justify-content-between mt-2 align-items-center">
                                    <div class="reply px-4">
                                        <label>Bình luận:
                                            <span class="text-dark">{{ $repItem['comment'] }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                @empty
                    <h5 class="text-secondary">Không có đánh giá nào</h5>
                @endforelse


            </div>
        </div>
    </section>
</div>
@push('scripts')
    <script></script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('reloadReviews', function(rating) {
                Livewire.emit('filterReviews', rating);
            });
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    </script>
    <script>
        var swiper = new Swiper(".mySwiper3", {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
            },
        });
    </script>
@endpush
