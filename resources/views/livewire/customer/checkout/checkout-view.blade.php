<div>
    @if ($this->cartCount == 0)
        <div class="card shadow m-2">
            <div class="card-body p-md-5">
                <h4 class="text-center">Không có sản phẩm nào để thành toán</h4>
                <a class="col-md-12 btn btn-info mb-2 p-2" href="{{ url('/cart') }}">Giỏ hàng</a>
                <a class="col-md-12 btn btn-warning mb-2 p-2" href="{{ url('/collections') }}">Mua ngay</a>
            </div>
        </div>
    @else
        <div class="row ">
            <div class="col-md-7">
                <div class="card ml-1 mb-5">
                    <div class="card-body position-relative">
                        <div class="position-absolute" style="top: 0;right: 0">
                            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#AddressModal">Chọn địa chỉ</button>
                        </div>
                        {{-- Modal start --}}
                        <div class="modal fade" id="AddressModal" tabindex="-1" aria-labelledby="AddressModalLabel"
                            aria-hidden="true" wire:ignore.self data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddressModalLabel">Địa chỉ</h5>
                                        <button type="button" class="btn-close resetBTN" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <p>Địa chỉ của tôi</p>
                                        @forelse ($this->customerAddress as $index)
                                            <div class="row position-relative">

                                                <div class="col-1">
                                                    <div class="position-absolute" style="top: -10%;right: 2%"
                                                        wire:click='deleteAddress({{ $index->id }})'>
                                                        <span class="mdi mdi-close-outline text-danger"></span>
                                                    </div>
                                                    <div class="toggle">
                                                        <a wire:click='clickAddress({{ $index->id }})'
                                                            class="button"></a>
                                                    </div>
                                                </div>
                                                <div class="col-11">
                                                    <span>
                                                        <span class="fw-bold">{{ $index->fullname }}</span> |
                                                        {{ $index->phone }}<br />
                                                        <p>{{ $index->address }}, {{ $index->wards }},
                                                            {{ $index->district }}, {{ $index->province }}</p>
                                                    </span>
                                                </div>
                                            </div>

                                            <hr>
                                        @empty
                                            Không có địa chỉ nào
                                        @endforelse
                                        <br>
                                        <a href="#" id="open-modal-child"
                                            class="btn btn-sm btn-outline-secondary">Thêm địa chỉ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal end --}}
                        {{-- Modal start --}}
                        <div id="modal-child" wire:model="showChildModal" class="modal fade" tabindex="-1"
                            role="dialog" wire:ignore.self data-bs-backdrop="static">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Địa chỉ mới</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <span>Họ và Tên</span>
                                                    <input type="text" class="form-control"
                                                        wire:model.defer="fullname">
                                                    @error('fullname')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <span>Số Điện Thoại</span>
                                                    <input type="text" class="form-control"
                                                        wire:model.defer="phone">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <span>Tỉnh/Thành Phố</span>
                                                <select wire:model="city" id="provinceSelect" class="form-control"
                                                    wire:ignore>
                                                    <option value="" selected>Chọn tỉnh/thành</option>
                                                </select>
                                                @error('city')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-2">
                                                <span>Quận/Huyện</span>
                                                <select wire:model="district" id="districtSelect" class="form-control"
                                                    wire:ignore>
                                                    <option value="" selected>Chọn quận/huyện</option>
                                                </select>
                                                @error('district')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-2">
                                                <span>Phường/Xã</span>
                                                <select wire:model="ward" id="wardSelect" class="form-control"
                                                    wire:ignore>
                                                    <option value="" selected>Chọn phường/xã</option>
                                                </select>
                                                @error('ward')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-2">
                                                <span>Địa Chỉ Cụ Thể</span>
                                                <textarea wire:model.defer="address" rows="3" class="form-control"></textarea>
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary resetBTN"
                                            id="back-to-parent">Trở
                                            lại</button>
                                        <button type="button" class="btn btn-primary" wire:click='addToAddress'>Hoàn
                                            thành</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal end --}}
                        <h6>Thông tin cá nhân</h6>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-4">
                                <label for="">Họ và Tên</label>
                                <input type="text" required id="fullname_address"
                                    wire:model.defer="fullname_address" class="form-control" wire:ignore>
                                @error('fullname_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="">Số Điện thoại</label>
                                <input type="text" required id="phone_address" wire:model.defer="phone_address"
                                    wire:ignore class="form-control">
                                @error('phone_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="">Email</label>
                                <input type="text" required id="email" wire:model.defer="email" wire:ignore
                                    class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="">Tỉnh/Thành Phố</label>
                                <select wire:model="city_address" id="city_address" class="form-control" wire:ignore>
                                    <option value="{{ $this->city_address }}" selected>Chọn tỉnh thành</option>
                                </select>
                                @error('city_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="">Quận/Huyện</label>
                                <select wire:model="district_address" id="district_address" class="form-control"
                                    wire:ignore>
                                    <option value="{{ $this->district_address }}" selected>Chọn quận huyện</option>
                                </select>
                                @error('district_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="">Phường/Xã</label>
                                <select wire:model="ward_address" id="ward_address" class="form-control" wire:ignore>
                                    <option value="{{ $this->ward_address }}" selected>Chọn phường xã</option>
                                </select>
                                @error('ward_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="">Địa chỉ cụ thể</label>
                                <textarea id="address2" wire:model.defer="address2" rows="4" class="form-control"></textarea>
                                @error('address2')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5" wire:init="initializeComponent()">
                <div class="card mr-1">
                    <div class="card-body">
                        <h6>Thông tin sản phẩm</h6>
                        <hr>
                        @php
                            $total_price = 0;
                        @endphp
                        <div class="row text-dark mb-2 font-weight-bold">
                            <div class="col-md-6">
                                Sản phẩm
                            </div>
                            <div class="col-md-3">
                                Số lượng
                            </div>
                            <div class="col-md-3">
                                Giá tiền
                            </div>
                        </div>
                        <div class="row text-dark mb-1 ">
                            @foreach ($carts as $cartItem)
                                <div class="col-md-6" style="height: 60px">
                                    <a href="">
                                        <label class="row">
                                            <div class="col-1">
                                                <img width="30px" height="30px"
                                                    src="{{ $cartItem->product->image }}" alt="">
                                            </div>

                                            <span class="col-10 truncate-text">
                                                <span data-toggle="tooltip"
                                                    title="{{ $cartItem->product->name }}">{{ $cartItem->product->name }}</span>
                                                @if ($cartItem->product_collection_id)
                                                    <br>
                                                    <span
                                                        class="fw-light">{{ $cartItem->productCollection->name_collection }}
                                                    </span>
                                                @endif
                                            </span>

                                        </label>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ $cartItem->quantity }}</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="">
                                        @if ($cartItem->product_collection_id)
                                            {{ number_format($cartItem->productCollection->price, 0, ',', '.') }}&#8363;
                                        @else
                                            {{ number_format($cartItem->product->price, 0, ',', '.') }}&#8363;
                                        @endif

                                    </label>
                                </div>
                                @php
                                    if ($cartItem->product_collection_id) {
                                        $total_price += $cartItem->productCollection->price * $cartItem->quantity;
                                    } else {
                                        $total_price += $cartItem->product->price * $cartItem->quantity;
                                    }
                                    
                                @endphp
                            @endforeach

                        </div>
                        <hr>
                        @php
                            $total_price += $this->fee;
                        @endphp
                        <h5 class="row">
                            <span class="col-5">Phí vận chuyển: </span>
                            <span
                                class="col-7 d-flex justify-content-end">{{ number_format($this->fee, 0, ',', '.') }}&#8363;</span>
                        </h5>
                        <h5 class="row">
                            <span class="col-5">Tổng cộng:</span>
                            <span class="col-7 d-flex justify-content-end">
                                {{ number_format($total_price, 0, ',', '.') }}&#8363;</span>
                        </h5>
                        @php
                            $this->total_price = $total_price;
                        @endphp
                        <hr>
                        <button type="button" wire:click='payment' class="btn btn-info col-md-12 w-100 mb-2">Thanh
                            toán sau khi nhận(COD)</button>
                        <br>
                        <div wire:ignore>
                            <div id="paypal-button-container">
                                <div id="smart-button-container">
                                    <div style="text-align: center;">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endif

</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        // ẩn hiện modal
        document.addEventListener('livewire:load', function() {
            Livewire.on('showParentModal', function() {
                $('#modal-child').modal('hide');
                $('#AddressModal').modal('show');
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('hideParentModal', function() {
                $('#AddressModal').modal('hide');
            });
        });
        document.getElementById('open-modal-child').addEventListener('click', function() {
            $('#AddressModal').modal('hide');
            $('#modal-child').modal('show');
        });
        document.getElementById('back-to-parent').addEventListener('click', function() {
            $('#modal-child').modal('hide');
            $('#AddressModal').modal('show');
        });
        // reset form
        $('.resetBTN').click(function() {
            Livewire.emit('resetAddToAddress');
        });
        const apiUrl = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/province';
        const apiUrl2 = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/district';
        const apiUrl3 = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id';
        const token = '3e93da2c-5bbd-11ee-af43-6ead57e9219a';

        const districtSelectElement = document.getElementById('districtSelect');
        const provinceSelectElement = document.getElementById('provinceSelect');
        const wardSelectElement = document.getElementById('wardSelect');
        axios.get(apiUrl, {
                headers: {
                    'Token': token
                }
            })
            .then(function(response) {
                response.data.data.forEach(function(province) {
                    const option = document.createElement('option');
                    option.value = province.ProvinceName;
                    option.dataset.id = province.ProvinceID;
                    option.text = province.ProvinceName;
                    provinceSelectElement.appendChild(option);
                });
                printResult();
            })
            .catch(function(error) {

                console.error(error);
            });


        provinceSelectElement.addEventListener('change', function() {
            const provinceId = parseInt($(this).find('option:selected').data('id'), 10);
            Livewire.emit('resetAddressFields', 1);
            axios.post(apiUrl2, {
                    province_id: provinceId
                }, {
                    headers: {
                        'Token': token
                    }
                })
                .then(function(response) {
                    districtSelectElement.innerHTML = '';
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.text = 'Chọn quận/huyện';
                    emptyOption.selected = true;
                    districtSelectElement.appendChild(emptyOption);
                    response.data.data.forEach(function(district) {
                        const option = document.createElement('option');
                        option.value = district.DistrictName;
                        option.dataset.id = district.DistrictID;
                        option.text = district.DistrictName;
                        districtSelectElement.appendChild(option);
                    });
                    printResult();
                })
                .catch(function(error) {
                    console.error(error);
                });
        });

        districtSelectElement.addEventListener('change', function() {
            const districtId = parseInt($(this).find('option:selected').data('id'), 10);
            Livewire.emit('resetAddressFields', 2);
            axios.post(apiUrl3, {
                    district_id: districtId
                }, {
                    headers: {
                        'Token': token
                    }
                })
                .then(function(response) {
                    wardSelectElement.innerHTML = '';
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.selected = true;
                    emptyOption.text = 'Chọn phường/xã';
                    wardSelectElement.appendChild(emptyOption);
                    response.data.data.forEach(function(ward) {
                        const option = document.createElement('option');
                        option.value = ward.WardName;
                        option.dataset.id = ward.WardCode;
                        option.text = ward.WardName;
                        wardSelectElement.appendChild(option);
                    });
                    printResult();

                })
                .catch(function(error) {
                    console.error(error);
                });
        });
        wardSelectElement.addEventListener('change', function() {
            printResult();
        });

        var printResult = () => {
            if ($("#districtSelect").find(':selected').data('id') != "" && $("#provinceSelect").find(':selected').data(
                    'id') != "" &&
                $("#wardSelect").find(':selected').data('id') != "") {
                var cityCode = $("#provinceSelect").find(':selected').data('id');
                var districtCode = $("#districtSelect").find(':selected').data('id');
                var wardCode = $("#wardSelect").find(':selected').data('id');
                Livewire.emit('updateCodes', cityCode, districtCode, wardCode);
            }
        }

        // callAPI2

        const provinceAddSelectElement = document.getElementById('city_address');
        const districtAddSelectElement = document.getElementById('district_address');
        const wardAddSelectElement = document.getElementById('ward_address');

        axios.get(apiUrl, {
                headers: {
                    'Token': token
                }
            })
            .then(function(response) {
                response.data.data.forEach(function(province) {
                    const option = document.createElement('option');
                    option.value = province.ProvinceName;
                    option.dataset.id = province.ProvinceID;
                    option.text = province.ProvinceName;
                    provinceAddSelectElement.appendChild(option);
                });
                printResultAdd();
            })
            .catch(function(error) {
                console.error(error);
            });


        provinceAddSelectElement.addEventListener('change', function() {
            const provinceAddId = parseInt($(this).find('option:selected').data('id'), 10);
            Livewire.emit('resetAddressFields', 3);
            axios.post(apiUrl2, {
                    province_id: provinceAddId
                }, {
                    headers: {
                        'Token': token
                    }
                })
                .then(function(response) {
                    districtAddSelectElement.innerHTML = '';
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.text = 'Chọn quận/huyện';
                    emptyOption.selected = true;
                    districtAddSelectElement.appendChild(emptyOption);
                    response.data.data.forEach(function(district) {
                        const option = document.createElement('option');
                        option.value = district.DistrictName;
                        option.dataset.id = district.DistrictID;
                        option.text = district.DistrictName;
                        districtAddSelectElement.appendChild(option);
                    });
                    printResultAdd();
                })
                .catch(function(error) {
                    console.error(error);
                });
        });

        districtAddSelectElement.addEventListener('change', function() {
            const districtAddId = parseInt($(this).find('option:selected').data('id'), 10);
            Livewire.emit('resetAddressFields', 4);
            axios.post(apiUrl3, {
                    district_id: districtAddId
                }, {
                    headers: {
                        'Token': token
                    }
                })
                .then(function(response) {
                    wardAddSelectElement.innerHTML = '';
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.selected = true;
                    emptyOption.text = 'Chọn phường/xã';
                    wardAddSelectElement.appendChild(emptyOption);
                    response.data.data.forEach(function(ward) {
                        const option = document.createElement('option');
                        option.value = ward.WardName;
                        option.dataset.id = ward.WardCode;
                        option.text = ward.WardName;
                        wardAddSelectElement.appendChild(option);
                    });
                    printResultAdd();

                })
                .catch(function(error) {
                    console.error(error);
                });
        });
        wardAddSelectElement.addEventListener('change', function() {
            printResultAdd();
        });

        var printResultAdd = () => {
            if ($("#district_address").find(':selected').data('id') != undefined && $("#city_address").find(':selected')
                .data('id') != undefined &&
                $("#ward_address").find(':selected').data('id') != undefined) {
                var cityCode = $("#city_address").find(':selected').data('id');
                var districtCode = $("#district_address").find(':selected').data('id');
                var wardCode = $("#ward_address").find(':selected').data('id');
                Livewire.emit('updateCodes', cityCode, districtCode, wardCode);
                serviceFee(districtCode, wardCode);
            }
        }
        document.addEventListener('livewire:load', function() {
            Livewire.on('addressDataChanged', function(city, district, ward) {
                updateSelectBoxes(city, district, ward);
                serviceFee(district, ward);
            });
        });
        async function updateSelectBoxes(cityId, districtId, wardId) {
            Livewire.emit('updateCodes', cityId, districtId, wardId);

            var cityResponse = await axios.get(apiUrl, {
                headers: {
                    'Token': token
                }
            });
            var cityData = cityResponse.data.data
            var citySelect = document.getElementById('city_address');
            citySelect.innerHTML = '';
            cityData.forEach(function(city) {
                var option = document.createElement('option');
                option.value = city.ProvinceName;
                option.text = city.ProvinceName;
                option.dataset.id = city.ProvinceID
                if (city.ProvinceID == cityId) {
                    option.selected = true;
                }
                citySelect.appendChild(option);
            });
            var districtResponse = await axios.post(apiUrl2, {
                province_id: parseInt(cityId, 10)
            }, {
                headers: {
                    'Token': token
                }
            });

            var districtData = districtResponse.data.data;
            var districtSelect = document.getElementById('district_address');
            districtSelect.innerHTML = '';
            districtData.forEach(function(district) {
                var option = document.createElement('option');
                option.value = district.DistrictName;
                option.text = district.DistrictName;
                option.dataset.id = district.DistrictID
                if (district.DistrictID == districtId) {
                    option.selected = true;
                }
                districtSelect.appendChild(option);
            });
            var wardResponse = await axios.post(apiUrl3, {
                district_id: parseInt(districtId, 10)
            }, {
                headers: {
                    'Token': token
                }
            });
            var wardData = wardResponse.data.data;
            var wardSelect = document.getElementById('ward_address');
            wardSelect.innerHTML = '';
            wardData.forEach(function(ward) {
                var option = document.createElement('option');
                option.value = ward.WardName;
                option.text = ward.WardName;
                option.dataset.id = ward.WardCode
                if (ward.WardCode == wardId) {
                    option.selected = true;
                }
                wardSelect.appendChild(option);
            });
        }
    </script>
    <script>
        const itemsDataJson = @json($this->ItemsData());
        const itemsData = JSON.parse(itemsDataJson);
        const totalWeightJson = @json($this->totalWeight());
        const totalWeight = JSON.parse(totalWeightJson);
        const apiFee = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee';
        const shopId = '4575887';
        let headers = {
            'Token': token,
            'ShopId': shopId
        }

        function serviceFee(districtCode, wardCode) {
            let ItemData = itemsData;
            let DataSet = {
                service_type_id: 2,
                from_district_id: 1566,
                to_district_id: parseInt(districtCode, 10),
                to_ward_code: wardCode.toString(),
                weight: parseInt(totalWeight),
                items: ItemData
            };

            axios.post(apiFee, DataSet, {
                headers: headers
            }, ).then(function(res) {
                var totalFee = res.data.data.total;
                Livewire.emit('updateTotalFee', totalFee);
            }).catch(function(error) {
                console.log(error);
            })
        }
    </script>
@endpush
