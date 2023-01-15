<x-app-layout :page-title="'Order #' . $order->id">
    <style>
    </style>
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
                        <div class="w-100 fs-18 fw-600">Date created</div>
                        <div class="fs-14 ">{{ date('F d, Y', strtotime($order->created_at)) }}</div>
                    </div>
                </div>
            </div>

            <div class="order-items-card pb-4">
                <div class="row">
                    <div class="col-lg-2 col-3">
                        <img src="{{ $order->course->uploads->getImageOptimizedFullName(150) }}" alt=""
                            class="thumbnail border w-100">
                    </div>
                    <div class="col-lg-10 col-9">
                        <div class="order-item-title fs-24 py-2 fw-600">
                            {{ $order->course->name }}
                        </div>
                        <div class="order-item-qty-price fs-16 pb-2">
                            <span class="fw-600">Price</span>
                            ${{ number_format($order->price/100, 2) }}
                        </div>
                        <div class="is_downloadable fw-600 fs-16">
                            @php
                                $orderStatus = Config::get('constants.service_order_status');
                            @endphp
                            <div class="d-flex mt-2">
                                <span class="d-block" data-item-id="{{ $order->id }}">
                                    @foreach ($orderStatus as $key => $status)
                                        @if ($key != 0)
                                            @if ($order->status == $key)
                                                {{ 'Status: ' . $status }}
                                            @endif
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
<script>
</script>
@endsection

</x-app-layout>
