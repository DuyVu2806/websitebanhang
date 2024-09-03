@extends('layouts.admin')

@section('title', 'Nhập Thêm Sản Phẩm')

@section('content')
    {{-- <livewire:admin.product.create-qty /> --}}
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary" style="margin-right: 7.5px">Quay
                    Lại</a>
            </div>
            <br>
            <br>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-4 col">Thông tin phiếu nhập hàng</h4>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Thủ Kho</label>
                        <input type="text" name="storekeeper" class="form-control">
                        <div class="text-danger error_msg" id="storekeeper"></div>
                    </div>
                    <div class="form-group col-6">
                        <label for="">Người ghi nhận</label>
                        <input type="text" name="receiving_clerk" class="form-control" readonly
                            value="{{ auth()->guard('admin')->user()->fullname }}">
                        <div class="text-danger error_msg" id="receiving_clerk"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">Nhà cung cấp</label>
                        <input type="text" name="supplier" class="form-control">
                        <div class="text-danger error_msg" id="supplier"></div>
                    </div>
                    <div class="form-group col-6">
                        <label for="">Tổng tiền hàng</label>
                        <input type="text" name="total_price" class="form-control">
                        <div class="text-danger error_msg" id="total_price"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Vận chuyển</label>
                        <input type="text" class="form-control" name="transportation">
                        <div class="text-danger error_msg" id="transportation"></div>
                    </div>
                </div>
                <hr style="margin-left: -1.81rem; margin-right: -1.81rem">
                <h4 class="mb-4 col">Thông tin sản phẩm</h4>
                <button type="button" id="add-product-button" class="btn btn-outline-primary">Thêm sản phẩm
                    mới</button>
                <div id="product-container">

                </div>

                <button type="submit" class="btn btn-lg btn-outline-primary float-right mt-2"
                    style="margin-right: 7.5px">XÁC
                    NHẬN</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function updateInputName(element, collectionCode) {
            const name = element.attr('name');
            const startIndex = name.indexOf('[');
            const endIndex = name.indexOf(']');
            if (startIndex !== -1 && endIndex !== -1) {
                const currentNumber = name.substring(startIndex + 1, endIndex);
                const newName = name.replace(currentNumber, collectionCode);
                element.attr('name', newName);
            }
        }

        function updateErrorMsgId(element, collectionCode) {
            const oldId = element.attr('id');
            if (oldId) {
                const newId = oldId.replace(/collections-\d+-/g, 'collections-' + collectionCode.split('_')[1] + '-');
                element.attr('id', newId);
            }
        }

        function updateCollectionAttributes(productItem) {
            const collections = productItem.find('.collection-input');
            collections.each(function(index) {
                const collectionCode = productItem.data('product-code') + '_' + index;
                $(this).attr('data-collection-code', collectionCode);
                $(this).find('input[name^="collections"]').each(function() {
                    updateInputName($(this), collectionCode);
                });
                $(this).find('.error_msg').each(function() {
                    updateErrorMsgId($(this), collectionCode);
                });
            });
        }

        function updateErrorIds() {
            const products = $('.product-item');
            products.each(function(productIndex) {
                const errors = $(this).find('.dynamic-error');
                errors.each(function() {
                    const oldId = $(this).attr('id');
                    const newId = oldId.replace(/\d+/, productIndex);
                    $(this).attr('id', newId);
                });
            });
        }
        $(document).ready(function() {
            let productIndex = 0;
            let collectionIndex = {};
            let key = false;
            $('#add-product-button').on('click', function() {
                const productTemplate = `
                <div class="border p-3 mt-3 product-item position-relative" data-product-code="" data-product-index="${productIndex}">
                    <div class="row">
                        <div class="form-group col">
                            <label for="product_${productIndex}_code">Mã sản phẩm</label>
                            <input type="text" class="form-control" name="products[${productIndex}][code]">
                            <div class="text-danger error_msg dynamic-error" id="products-${productIndex}-code"></div>
                        </div>
                        <div class="form-group col">
                            <label for="product_${productIndex}_name">Tên sản phẩm</label>
                            <input type="text" class="form-control product-name-input" name="products[${productIndex}][name]">
                            <div class="text-danger error_msg dynamic-error" id="products-${productIndex}-name"></div>
                            
                        </div>
                        <div class="form-group col">
                            <label for="product_${productIndex}_quantity">Nhập số lượng</label>
                            <input type="text" class="form-control" name="products[${productIndex}][quantity]">
                            <div class="text-danger error_msg dynamic-error" id="products-${productIndex}-quantity"></div>
                        </div>
                        <div class="form-group col">
                            <label for="product_${productIndex}_price">Giá tiền</label>
                            <input type="text" class="form-control product-price-input" name="products[${productIndex}][price]">
                            <div class="text-danger error_msg dynamic-error" id="products-${productIndex}-price"></div>
                        </div>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button class="btn btn-outline-primary add-collection mb-2" type="button">Thêm loại sản phẩm</button>
                            <div class="product-info"></div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm delete-product position-absolute" type="button" style="top: 0;right: 0">Xóa</button>
                    </div>
                    `;
                $('#product-container').append(productTemplate);
                productIndex++;
            });
            $(document).on('change', 'input[name^="products"][name$="[code]"]', function() {
                const productCode = $(this).val();
                const productItem = $(this).closest('.product-item');
                productItem.attr('data-product-code', productCode);
                const productInfoContainer = $(this).closest('.product-item').find('.product-info');
                const productNameInput = $(this).closest('.product-item').find('.product-name-input');
                const productOriginalPriceInput = $(this).closest('.product-item').find('.product-original-price-input');
                const productPriceInput = $(this).closest('.product-item').find('.product-price-input');
                $.ajax({
                    url: "{{ route('admin.product.getProduct', ['product_code' => '__productCode__']) }}"
                        .replace('__productCode__', productCode),
                    type: 'GET',
                    success: function(response) {
                        let productInfo = '';
                        productNameInput.val(response.product.name);
                        productPriceInput.val(response.product.price);
                        if (response.collection && response.collection.length >
                            0) {
                            response.collection.forEach((collection, index) => {

                                const collectionCode = productCode + '_' + index;

                                if (!collectionIndex[productCode]) {
                                    collectionIndex[productCode] = index;
                                } else {
                                    collectionIndex[productCode] = index;
                                }

                                productInfo += `
                                    <div class="collection-input border p-3 mb-2 row" data-collection-code="${collectionCode}">
                                        <input type="text" name="collections[${collectionCode}][id]" value="${collection.id}" hidden>
                                        <div class="form-group col">
                                            <label for="">Tên loại sản phẩm</label>
                                            <input type="text" class="form-control" name="collections[${collectionCode}][name_collection]" value="${collection.name_collection}">
                                            <div class="text-danger error_msg " id="products-${productIndex-1}-collections-${index}-name_collection"></div>
                                        </div>
                                        <div class="form-group col">
                                            <label for="">Số lượng thêm</label>
                                            <input type="text" class="form-control" name="collections[${collectionCode}][quantity]" value="0">
                                            <div class="text-danger error_msg " id="products-${productIndex-1}-collections-${index}-quantity"></div>
                                        </div>
                                        <div class="form-group col">
                                            <label for="">Giá tiền</label>
                                            <input type="text" class="form-control" name="collections[${collectionCode}][price]" value="${collection.price}">
                                            <div class="text-danger error_msg " id="products-${productIndex-1}-collections-${index}-price"></div>
                                        </div>
                                    </div>
                                `;
                            });
                        }
                        productInfoContainer.html(productInfo);
                        key = true;
                    },
                    error: function() {
                        productInfoContainer.html('<p>Sản phẩm không tồn tại</p>');
                    }
                });
            });
            $(document).on('click', '.add-collection', function() {
                if (key) {
                    const productItem = $(this).closest('.product-item');
                    const productCode = productItem.find('input[name^="products"][name$="[code]"]').val();
                    const prodIndex = productItem.data('product-index');
                    if (typeof collectionIndex[productCode] === 'undefined') {
                        collectionIndex[productCode] = 0;
                    } else {
                        collectionIndex[productCode]++;
                    }
                    const collectionCode = productCode + '_' + collectionIndex[productCode];
                    const collectionTemplate = `
                        <div class="collection-input border p-3 mb-2 row position-relative" data-collection-code="${collectionCode}">
                            <div class="form-group col">
                                <label for="">Tên loại sản phẩm</label>
                                <input type="text" class="form-control" name="collections[${collectionCode}][name_collection]">
                                <small class="text-danger error_msg" id="products-${prodIndex}-collections-${collectionIndex[productCode]}-name_collection"></small>
                            </div>
                            <div class="form-group col">
                                <label for="">Số lượng thêm</label>
                                <input type="text" class="form-control" name="collections[${collectionCode}][quantity]" >
                                <small class="text-danger error_msg" id="products-${prodIndex}-collections-${collectionIndex[productCode]}-quantity"></small>
                            </div>
                            <div class="form-group col">
                                <label for="">Giá tiền</label>
                                <input type="text" class="form-control" name="collections[${collectionCode}][price]">
                                <small class="text-danger error_msg" id="products-${prodIndex}-collections-${collectionIndex[productCode]}-price"></small>
                            </div>
                            <a class="remove-collection position-absolute" style="top: -9%;right: -0.4rem;font-size:20px;color:red"><i class="fa-regular fa-circle-xmark"></i></a>
                        </div>
                    `;

                    productItem.find('.product-info').append(collectionTemplate);
                }

            });

            $(document).on('click', '.remove-collection', function() {
                const collectionInput = $(this).closest('.collection-input');
                const productItem = collectionInput.closest('.product-item');
                const productCode = productItem.data('product-code');
                $(this).closest('.collection-input').remove();
                updateCollectionAttributes(productItem);
                collectionIndex[productCode]--;
            });

            $(document).on('click', '.delete-product', function() {
                const productCode = $(this).closest('.product-item').data('product-code');
                $(this).closest('.product-item').remove();
                updateErrorIds();
                $('.product-item').each(function(index) {
                    $(this).attr('data-product-index', index);
                    $(this).find('input[name^="products"]').each(function() {
                        const newName = $(this).attr('name').replace(/\[\d+\]/, '[' +
                            index + ']');
                        $(this).attr('name', newName);
                    });
                    $('.collection-input').each(function() {
                        const collectionCode = $(this).attr('data-collection-code');
                        $(this).find('.error_msg').each(function() {
                            const oldId = $(this).attr('id');
                            const newId = oldId.replace(/products-\d+-/,
                                'products-' +
                                index + '-');
                            console.log(newId);
                            $(this).attr('id', newId);
                        });
                    });
                });
                collectionIndex[productCode] = undefined;
                productIndex--;

            });

            // post data
            $('form').on('submit', function(event) {
                event.preventDefault();
                $('.error_msg').empty();
                if ($('#product-container .product-item').length === 0) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Vui lòng thêm ít nhất một sản phẩm',
                    })
                    return;
                }
                const formData = {
                    storekeeper: $('input[name="storekeeper"]').val(),
                    receiving_clerk: $('input[name="receiving_clerk"]').val(),
                    supplier: $('input[name="supplier"]').val(),
                    total_price: $('input[name="total_price"]').val(),
                    transportation: $('input[name="transportation"]').val(),
                    products: [],
                };

                $('.product-item').each(function() {
                    const product = {
                        code: $(this).find('input[name^="products"][name$="[code]"]').val(),
                        name: $(this).find('input.product-name-input').val(),
                        quantity: $(this).find('input[name^="products"][name$="[quantity]"]')
                            .val(),
                        original_price: $(this).find('input.product-original-price-input').val(),
                        price: $(this).find('input.product-price-input').val(),
                        collections: [],
                    };

                    $(this).find('.collection-input').each(function() {
                        const collection = {
                            id: $(this).find(
                                'input[name$="[id]"]').val(),
                            name_collection: $(this).find(
                                'input[name$="[name_collection]"]').val(),
                            quantity: $(this).find('input[name$="[quantity]"]').val(),
                            price: $(this).find('input[name$="[price]"]').val(),
                        };

                        product.collections.push(collection);
                    });

                    formData.products.push(product);
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route('admin.product.post_create_qty') }}',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        alert(response.message);
                        window.history.back();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                if (xhr.responseJSON) {
                                    var $errorContainer = $('#' + field.replace(/\./g,
                                        '-'));
                                    $errorContainer.empty();
                                    $.each(messages, function(index, message) {
                                        $errorContainer.append($('<small>')
                                            .text(
                                                message));
                                    });
                                    $errorContainer.show();
                                }

                            });
                        } else {
                            console.log(xhr);
                        }
                    }
                });
            });
        });
    </script>
@endpush
