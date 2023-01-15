<x-guest-layout page-title="Shipping Detail">
    <div class="checkout-container">
        <div class="checkout-wrap">
            <form id="payment-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-xl-8 col-lg-10 ml-auto p-3">
                            <div class="logo py-4 fw-800 fs-24">#JEWELRYCG</div>
                            <nav class="pb-4" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                                    @if ($isIncludeShipping)
                                        <li class="breadcrumb-item"><a href="/checkout/shipping">Shipping</a></li>
                                    @endif
                                    <li class="breadcrumb-item" aria-current="page"><a
                                            href="/checkout/billing">Billing</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                                </ol>
                            </nav>
                            <div class="checkout-card">
                                <div class="checkout-card-body">
                                    <h3 class="mb-3 fs-20">Payment Information</h3>
                                    <input type="hidden" name="" value="{{ Session::get('billing_address1') }}"
                                        id="address1">
                                    <input type="hidden" name="" value="{{ Session::get('billing_address2') }}"
                                        id="address2">
                                    <input type="hidden" name="" value="{{ Session::get('billing_city') }}"
                                        id="city">
                                    <input type="hidden" name="" value="{{ Session::get('billing_state') }}"
                                        id="state">
                                    <input type="hidden" name="" value="{{ Session::get('billing_country') }}"
                                        id="country">
                                    <input type="hidden" name="" value="{{ Session::get('billing_zipcode') }}"
                                        id="zipcode">
                                    <input type="hidden" name=""
                                        value="{{ Session::get('billing_phonenumber') }}" id="phonenumber">
                                    <input type="hidden" name="" value="{{ Session::get('billing_email') }}"
                                        id="email">
                                    <input type="hidden" name=""
                                        value="{{ Session::get('billing_firstname') . ' ' . Session::get('billing_lastname') }}"
                                        id="name">
                                    <div id="payment-element">
                                        <!--Stripe.js injects the Payment Element-->
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button id="submit" class="btn btn-primary mt-2">
                                            <div class="spinner hidden" id="spinner"></div>
                                            <span id="button-text">Pay now</span>
                                        </button>
                                        <div id="payment-message" class="hidden text-center text-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 checkout-sidebar">
                        <div class="col-xl-8 col-lg-10 mr-auto p-3">
                            <div class="cart-items-card">
                                <div class="card-body">
                                    <div class="py-4 fw-800 fs-24">Order Details</div>
                                    <x-checkout-cart
                                        locale="checkout"
                                        :coupon-id="$coupon_id"
                                        :instance="isset($buy_now_mode) && $buy_now_mode == 1 ? 'buy_now' : 'default'"
                                        :hasCoupon="true"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_key = '{{ config('app.stripe_key') }}';
        const payment_intent_route = '{{ route('checkout.payment.intent') }}';
        const _token = '{{ csrf_token() }}';
        const place_order_route = '{{ route('checkout.store') }}';
        const order_cancel_route = '{{ route('checkout.cancel') }}';
        const finish_page = '{{ route('checkout.finished') }}';
        const buy_now_mode = '{{ $buy_now_mode ?? 0 }}';
    </script>
    <script src="{{ asset('js/checkout.js') }}"></script>

</x-guest-layout>
