<x-guest-layout page-title="Shipping Detail">
    <div class="checkout-container">
        <div class="checkout-wrap">
            <div class="row">
                <div class="col-lg-6">
                    <div class="col-xl-8 col-lg-10 ml-auto p-3">
                        <div class="logo py-4 fw-800 fs-24">#JEWELRYCG</div>
                        <nav class="pb-4" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                                <li class="breadcrumb-item active">Shipping</li>
                                <li class="breadcrumb-item" aria-current="page">Billing</li>
                                <li class="breadcrumb-item" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                        <form action="{{ url('/checkout/shipping') }}" method="POST">
                            @csrf
                            <div class="checkout-card">
                                <div class="checkout-card-body">
                                    <h3 class="mb-3 fs-20">Shipping method</h3>
                                    <div class="row mb-3">
                                        @foreach ($shippings as $i => $ship)
                                            <div class="option mb-2">
                                                <input type="radio" value="{{ $ship->id }}"
                                                    class="btn-check shipping_option" name="shipping_option"
                                                    id="option{{ $i }}" autocomplete="off"
                                                    @if ($i == 0) checked @endif
                                                    data-price="{{ $ship->price / 100 }}" />
                                                <label class="card btn mb-2 p-3 shipping-method-btn shipping-radio"
                                                    for="option{{ $i }}" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-8 text-left">{{ $ship->name }}
                                                            ({{ $ship->description }})
                                                        </div>
                                                        <div class="col-4 text-right">${{ $ship->price / 100 }}
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-card">
                                <div class="checkout-card-body">

                                <h3 class="mb-3 fs-20">Shipping Address</h3>
                                    @include('includes.validation-form')
                                    <x-user-info :countries="$countries" :billing="$shipping" :location="$location" />
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            @if (auth()->id())
                                                <label for="isRemember">
                                                    <input type="checkbox" name="isRemember" id="isRemember">
                                                    @if($shipping !== "NULL") 
                                                        Update Address
                                                    @else
                                                        Remember Address
                                                    @endif
                                                </label>
                                            @endif
                                            <button type="submit" class="btn btn-primary float-end">Continue</button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 checkout-sidebar">
                    <div class="col-xl-8 col-lg-10 mr-auto p-3">
                        <div class="cart-items-card">
                            <div class="card-body">
                                <div class="py-4 fw-800 fs-24">Order Details</div>
                                <x-checkout-cart locale="checkout" :instance="'default'" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            var totalPrice = parseFloat($('#total_price').text().split('$')[1].trim().replaceAll(',', '')) * 1 - parseFloat($('#shipping_price').text().split('$')[
                1].trim().replaceAll(',', '')) * 1;
            $('input.shipping_option').change(function() {
                var shippingPrice = $(this).attr('data-price');

                $('#shipping_price').text(`$${shippingPrice}`);

                $('#total_price').text(
                    `$${parseFloat((Math.round((totalPrice + shippingPrice * 1) * 100) / 100).toFixed(2)).toLocaleString()}`);
            })

            var shippingPrice = $('#option0').attr('data-price');

            $('#shipping_price').text(`$${shippingPrice}`);

            $('#total_price').text(
                `$${parseFloat((Math.round((totalPrice + shippingPrice * 1) * 100) / 100).toFixed(2)).toLocaleString()}`);
        })
    </script>
</x-guest-layout>
