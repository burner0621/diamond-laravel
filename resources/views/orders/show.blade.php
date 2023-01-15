<x-app-layout :page-title="'Order #' . $order->order_id">
    <div class="container">
        <div class="col-lg-8 col-md-10 py-9 mx-auto checkout-wrap">
            <h1 class="fw-800 mb-3">Thanks for shopping with us!</h1>
            <p>We appreciate your order, we’re currently processing it. So hang tight, and we’ll send you confirmation
                very soon!</p>
            <div class="order-items-card border-bottom py-4 mb-5">
                <div class="row">
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Order number</div>
                        <div class="fs-14 text-primary">#{{ $order->order_id }}</div>
                    </div>
                    <div class="col-lg-3 col-6 mb-2">
                        <div class="w-100 fs-18 fw-600">Payment status</div>
                        <div class="fs-14 ">
                            {{ ucwords(Config::get('constants.oder_payment_status')[$order->status_payment]) }}</div>
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
                                <img src="{{ $item->productVariant->uploads->getImageOptimizedFullName(150) }}" alt=""
                                    class="thumbnail border w-100">
                            @else
                                <img src="{{ $item->uploads->getImageOptimizedFullName(150) }}" alt=""
                                    class="thumbnail border w-100">
                            @endif
                        </div>
                        <div class="col-lg-10 col-9">
                            <div class="order-item-title fs-24 py-2 fw-600">
                                @php
                                    if ($item->product_variant != 0) {
                                        echo $item->product_name . ' - ' . $item->product_variant_name;
                                    } else {
                                        echo $item->product_name;
                                    }
                                @endphp
                            </div>
                            <div class="order-item-qty-price fs-16 pb-2"><span class="fw-600">Quantity</span>
                                {{ $item->quantity }} | <span class="fw-600">Price</span>
                                ${{ number_format($item->price / 100, 2) }}</div>
                            <div class="is_downloadable fw-600 fs-16">
                                @if ($item->product_isdigital)
                                    @if ($item->productVariant)
                                        @if (!$item->productVariant->has('asset') || $item->productVariant->asset->file_name == 'none')
                                            File unavailable. Please contact support.
                                        @else
                                            <a href="{{route('download').'/'.$order->id.'/'.Crypt::encryptString($item->productVariant->asset->id)}}" class="btn btn-sm btn-primary">

                                                <i class="bi bi-download mr-10px"></i> Download</a>
                                        @endif
                                    @else
                                        @if (!$item->product_digital_download_assets)
                                            File unavailable. Please contact support.
                                        @else
                                            <a href="{{route('download').'/'.$order->id.'/'.Crypt::encryptString($item->product->digital->id)}}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-download mr-10px"></i> Download</a>
                                        @endif
                                    @endif
                                @endif

                                @php
                                    $orderStatus = Config::get('constants.order_item_status_fulfillment');
                                @endphp
                                <div class="d-flex mt-2">
                                    <span class="d-block" data-item-id="{{ $item->id }}">
                                        @foreach ($orderStatus as $key => $status)
                                            @if ($key != 0)
                                                @if ($item->status_fulfillment == $key)
                                                    {{ 'Status: ' . $status }}
                                                @endif
                                            @endif
                                        @endforeach
                                        @if ($item->status_fulfillment == 2)
                                            {{ ' - Tracking #: ' . $item->status_tracking }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-lg-4 mt-3">
                    <div class="card">
                        <div class="fs-18 py-2 fw-600 card-header">Summary</div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="fw-600">Subtotal:</span>
                                ${{ number_format($order->total / 100, 2, '.', ',') }}
                            </div>
                            @if ($order->discount)
                                <div class="mb-2">
                                    <span class="fw-600">Discount:</span>
                                    ${{ number_format($order->discount / 100, 2, '.', ',') }}
                                </div>
                            @endif
                            <div class="mb-2">
                                <span class="fw-600">Shipping:</span>
                                ${{ number_format($order->shipping_total / 100, 2, '.', ',') }}
                            </div>
                            <div class="mb-2">
                                <span class="fw-600">Tax:</span>
                                ${{ number_format($order->tax_total / 100, 2, '.', ',') }}
                            </div>
                            <div class="mb-2">
                                <span class="fw-600">Total:</span>
                                ${{ number_format($order->grand_total / 100, 2, '.', ',') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3">
                    <div class="card">
                        <div class="fs-18 py-2 fw-600 card-header">Billing Address</div>
                        <div class="card-body">
                            @include('includes.validation-form')
                            <x-order-info :order="$order" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
