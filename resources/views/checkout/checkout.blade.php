<x-app-layout page-title="Cart">
    <x-slot:scripts>
        <script src="https://js.stripe.com/v3/"></script>
        <script defer>
            const stripe_key = '{{ config('app.stripe_key') }}';
            const payment_intent_route = '{{ route('checkout.payment.intent') }}';
            const _token = '{{ csrf_token() }}';
            const place_order_route = '{{ route('checkout.store') }}';
            const order_cancel_route = '{{ route('checkout.cancel') }}';
            const finish_page = '{{ route('checkout.finished') }}';
            const buy_now_mode = '{{ $buy_now_mode ?? 0 }}';
        </script>
        <script src="{{ asset('js/checkout.js') }}" defer></script>
        </x-slot>
        <div class="container">
            <form id="payment-form">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3">Basic Details</div>
                                @include('includes.validation-form')
                                <x-user-info />

                                <hr>

                                <div id="payment-element">
                                    <!--Stripe.js injects the Payment Element-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3">Order Details</div>
                                <x-checkout-cart locale="checkout" :instance="isset($buy_now_mode) && $buy_now_mode == 1 ? 'buy_now' : 'default'" />
                                <div class="d-grid gap-2">
                                    <button id="submit" class="btn btn-primary">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="button-text">Pay now</span>
                                    </button>
                                    <div id="payment-message" class="hidden text-center text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-slot:scripts>
</x-app-layout>
