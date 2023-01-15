@extends('backend.layouts.app', ['activePage' => 'orders', 'title' => 'Order', 'navName' => 'orderslist', 'activeButton' => 'catalogue'])

@section('content')
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title">Order</h1>
        </div>
    </div>

    <div class="container">
        <div class="col-lg-10 col-md-12 py-4 mx-auto checkout-wrap">
            <div class="order-items-card border-bottom py-4 mb-4">
                <div class="row">
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Order number</div>
                        <div class="fs-14 text-primary">#{{ $order->order_id }}</div>
                    </div>
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Payment status</div>
                        <div class="fs-14" title="{{ $order->status_payment_reason }}">
                            {{ ucwords(Config::get('constants.oder_payment_status')[$order->status_payment]) }}
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Fufilment status</div>
                        <div class="fs-14 ">
                            @php
                                $status = 'Fulfilled';
                                foreach ($order->items as $key => $item) {
                                    if ($item->status_fulfillment == '1') {
                                        $status = 'Unfulfilled';
                                    }
                                }
                                
                                echo $status;
                            @endphp
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Date created</div>
                        <div class="fs-14 ">{{ date('F d, Y', strtotime($order->created_at)) }}</div>
                    </div>
                </div>
            </div>

            @foreach ($order->items as $key => $item)
                <div class="order-items-card pb-4">
                    <div class="row">
                        <div class="col-lg-2 col-3">
                            @if ($item->productVariant && $item->productVariant->uploads)
                                <img src="{{ $item->productVariant->uploads->getImageOptimizedFullName(150) }}"
                                    alt="" class="thumbnail border w-100">
                            @else
                                <img src="{{ $item->product->uploads->getImageOptimizedFullName(150) }}" alt=""
                                    class="thumbnail border w-100">
                            @endif
                        </div>
                        <div class="col-lg-10 col-9">
                            <div class="order-item-title fs-24 mt-2 fw-600">
                                @php
                                    if ($item->product_variant != 0) {
                                        echo $item->product_name . ' - ' . $item->product_variant_name;
                                    } else {
                                        echo $item->product_name;
                                    }
                                @endphp
                            </div>
                            <div class="order-item-qty-price fs-16 mt-2"><span class="fw-600">Quantity:</span>
                                {{ $item->quantity }} | <span class="fw-600">Price</span>
                                ${{ number_format($item->price / 100, 2) }}
                            </div>
                            <div class="is_downloadable mt-2" data-item-id="{{ $item->id }}"
                                data-product-id="{{ $item->product->id }}" data-variant-id="{{ $item->product_variant }}"
                                data-product-digital-assets="{{ $item->product->digital_download_assets }}">
                                @if ($item->product->is_digital)
                                    @if ($item->productVariant)
                                        @if (!$item->productVariant->asset || $item->productVariant->asset->file_name == 'none')
                                            <span class="fs-14 badge bg-danger">No digital asset attached</span>
                                        @else
                                            <span class="fs-14 badge bg-success">Digital asset attached</span>
                                            <span class="fs-14 mt-2 d-block" class=""
                                                data-product-id="{{ $item->id }}">{{ $item->productVariant->asset->file_original_name . '.' . $item->productVariant->asset->extension }}</span>
                                        @endif

                                        <div class="card-body">
                                            <label class="btn btn-primary btn-sm mt-2 getFileManagerModel cursor-pointer"
                                                onclick="openFileMangerModalVariant(event)"><i
                                                    class="bi bi-upload mr-10px"></i> Select
                                                asset</label>
                                            <input type="hidden" class="variant_assets" name="variant_assets"
                                                value="{{ $item->productVariant->digital_download_assets }}">
                                        </div>
                                    @else
                                        @if (!$item->product->digital_download_assets)
                                            <span class="fs-14 badge bg-danger">No digital asset attached</span>
                                        @else
                                            <span class="fs-14 badge bg-success">Digital asset attached</span>
                                            <span class="fs-14 mt-2 d-block" class=""
                                                data-product-id="{{ $item->id }}">{{ $item->product->digitalImage->file_original_name . '.' . $item->product->digitalImage->extension }}</span>
                                        @endif

                                        <div class="card-body">
                                            <label class="btn btn-primary btn-sm mt-2 getFileManagerModel cursor-pointer"
                                                onclick="openFileMangerModalDigital(event)"><i
                                                    class="bi bi-upload mr-10px"></i> Select
                                                asset</label>
                                            <input type="hidden" class="digital_assets" name="digital_download_assets"
                                                value="{{ $item->product->digital_download_assets }}">
                                        </div>
                                    @endif
                                @endif

                                @php
                                    $orderStatus = Config::get('constants.order_item_status_fulfillment');
                                @endphp
                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <select class="order-status form-select w-100"
                                                data-item-id="{{ $item->id }}">
                                                @foreach ($orderStatus as $key => $status)
                                                    @if ($key != 0)
                                                        <option @if ($item->status_fulfillment == $key) selected @endif
                                                            value="{{ $key }}">{{ $status }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input
                                                class='track_number @if ($item->status_fulfillment != 2) d-none @endif track_number form-control w-100'
                                                type='text' placeholder='Tracking Number '
                                                value='{{ $item->status_tracking }}' />
                                        </div>
                                    </div>
                                </div>
                                <button class='allsave_button btn btn-sm btn-primary mt-2 d-none'
                                    onclick="AllSave(event)">save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-lg-4">
                <h5 class="fs-18 py-2 fw-600">Billing Address</h5>
                @include('includes.validation-form')
                <x-order-info :order="$order" />
            </div>

            <div class="col-lg-4">
                <button class="btn btn-sm btn-warning mt-2" onclick="mark_as_canceled({{ $order->id }})">Mark as
                    canceled
                </button>
                <button class="btn btn-sm btn-danger mt-2" onclick="mark_as_chargeback({{ $order->id }})">Mark as
                    chargeback
                </button>
            </div>
        </div>
    </div>

    <div id="fileManagerContainer"></div>

    <script>
        $(function() {
            $(".track_number").change(function() {
                $(this).closest(".is_downloadable").find('.allsave_button').removeClass('d-none');
            })
            $('.order-status').change(function() {
                $(this).closest(".is_downloadable").find('.allsave_button').removeClass('d-none');
                $(this).closest(".is_downloadable").find(".track_number").addClass('d-none');
                if ($(this).val() == '2') {
                    $(this).closest(".is_downloadable").find('.track_number').removeClass('d-none');
                }
                // } else {
                //     $(this).closest(".is_downloadable").find(".allsave_button").addClass('d-none');
                // }
            });

        });

        function AllSave(e) {
            var orderItemId = $(e.target).closest(".is_downloadable").attr("data-item-id");

            $.ajax({
                url: "{{ url('backend/orders/item') }}" + "/" + orderItemId,
                type: 'put',
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: $(e.target).closest(".is_downloadable").find(".order-status").val()
                },
                success: function(data) {
                    console.log(data)
                }
            })

            // Send if status is 2 aka shipped
            if ($(e.target).closest(".is_downloadable").find(".order-status").val() == 2) {
                $.ajax({
                    url: "{{ url('backend/orders/status_tracking/') }}" + "/" + orderItemId,
                    type: 'put',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: $(e.target).closest(".is_downloadable").find(".track_number").val()
                    },
                    async: false,
                    success: function(data) {
                        console.log(data)
                    }
                })
            }

            // send if status is 3 aka delivered
            if ($(e.target).closest(".is_downloadable").find(".order-status").val() == 3) {
                $.ajax({
                    url: "{{ url('backend/orders/status_tracking/') }}" + "/" + orderItemId,
                    type: 'put',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: $(e.target).closest(".is_downloadable").find(".track_number").val()
                    },
                    async: false,
                    success: function(data) {
                        console.log(data)
                    }
                })
            }

            var productId = $(e.target).closest(".is_downloadable").attr("data-product-id");
            var variantId = $(e.target).closest(".is_downloadable").attr("data-variant-id");

            if (variantId == '0' && variantId) {
                $.ajax({
                    url: "{{ url('backend/products/update_digital_assets/') }}" + "/" + productId,
                    type: 'put',
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value: $(e.target).closest(".is_downloadable").find(".digital_assets").val(),
                        orderId: orderItemId
                    },
                    success: function(data) {
                        console.log(data)
                    }
                })
            } else {
                $.ajax({
                    url: "{{ url('backend/products/update_variant_assets/') }}" + "/" + variantId,
                    type: 'put',
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value: $(e.target).closest(".is_downloadable").find(".variant_assets").val()
                    },
                    success: function(data) {
                        console.log(data)
                    }
                })
            }

            // location.reload();
        }

        function openFileMangerModalDigital(e) {
            var target = $(e.target);
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function(data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function(selectedId, filePath) {
                        $(target).closest(".is_downloadable").find(".digital_assets").val(
                            selectedId);
                    }
                    var digital_assets = $(target).closest(".is_downloadable").find(
                        ".digital_assets").val();
                    if (digital_assets == '') digital_assets = [];
                    setSelectedItemsCB(getSelectedItem, [digital_assets], false);
                    $(target).closest(".is_downloadable").find(".allsave_button").removeClass(
                        'd-none');
                }
            })
        }

        function openFileMangerModalVariant(e) {
            var target = $(e.target);
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function(data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function(selectedId, filePath) {
                        $(target).closest(".is_downloadable").find(".variant_assets").val(
                            selectedId);
                    }
                    var digital_assets = $(target).closest(".is_downloadable").find(
                        ".variant_assets").val();
                    if (digital_assets == '') digital_assets = [];
                    setSelectedItemsCB(getSelectedItem, [digital_assets], false);
                    $(target).closest(".is_downloadable").find(".allsave_button").removeClass(
                        'd-none');
                }
            })
        }

        let mark_as_canceled = function(order_id) {
            $.ajax({
                url: '{{ route('backend.orders.mark_as_canceled') }}',
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    order_id: order_id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        if (confirm("Order successfully marked as canceled!") == true) {
                            window.location.reload();
                        } else {
                            window.location.reload()
                        }
                    }
                }
            })
        }

        let mark_as_chargeback = function(order_id) {
            $.ajax({
                url: '{{ route('backend.orders.mark_as_chargeback') }}',
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    order_id: order_id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        if (confirm("Order successfully marked as chargeback!") == true) {
                            window.location.reload();
                        } else {
                            window.location.reload()
                        }
                    }
                }
            })
        }
    </script>
@endsection
