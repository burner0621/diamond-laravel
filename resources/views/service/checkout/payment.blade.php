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
                                  <li class="breadcrumb-item"><a href="/services/{{ $package->service->slug }}">Services</a></li>
                                  <li class="breadcrumb-item" aria-current="page"><a href="services/checkout/{{$package->id}}/">Billing</a></li>
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
                                  <div class="cart-item mb-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{ $package->service->uploads->getImageOptimizedFullName() }}" alt="thumb" class="thumbnail border rounded w-100">
                                        </div>
                                        <div class="col-8">
                                            <div class="item-meta text-nowrap mb-2">
                                                {{$package->service->name}} ({{ $package->name }})
                                            </div>
                                            <div class="item-meta mb-2"><span class="fw-800">Delivery Time:</span> {{ $package->delivery_time }} days</div>
                                            <div class="item-meta mb-2"><span class="fw-800">Revisions:</span> {{ $package->revisions }}</div>
                                        </div>
                                        <div class="col-1 text-right">
                                            <span class="text-primary fw-800">${{ number_format($package->price / 100, 2, ".", ",") }}</span>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="cart-item mb-3 pt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="fw-800">Sub Total</span>
                                        </div>
                                        <div class="col-auto ml-auto text-right">
                                            <span class="fw-800" id="spnSubTotalPrice">
                                                ${{ number_format($package->price / 100, 2, '.', ',') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if (isset($hasCoupon) && $hasCoupon == true)
                                <div class="cart-item">
                                    <div class="row mb-3">
                                        <span class="fw-800">Coupon Code</span>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-10">
                                            <input id="txtCouponCode" class="form-control" placeholder="Enter Coupon Code">
                                            <div id="divCouponErrorMsg" class="d-none mt-1 ms-2 text-danger fw-bold fs-14"></div>
                                        </div>
                                        <div class="col-2">
                                            <input type="button" id="btnApplyCoupon" class="btn btn-sm btn-primary" value="Apply"/>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="cart-item mb-3 d-none" id="divDiscount">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="fw-800" id="divCouponName"></span>
                                        </div>
                                        <div class="col-auto ml-auto text-right">
                                            <span class="fw-800" id="spnDiscountPrice"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="cart-item mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="fw-800">Tax</span>
                                        </div>
                                        <div class="col-auto ml-auto text-right">
                                            <span class="fw-800" id="spnTaxPrice">
                                                0
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-item mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="fw-800">Total</span>
                                        </div>
                                        <div class="col-auto ml-auto text-right">
                                            <span class="fw-800 text-primary" id="spnTotalPrice">
                                                ${{number_format($package->price / 100, 2, ".", ",")}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
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
      const payment_intent_route = '/services/checkout/intent/{{ $package->id }}';
      const _token = '{{ csrf_token() }}';
      const place_order_route = '/services/checkout/store/{{ $package->id }}';
      const order_cancel_route = '{{ route('services.cancel') }}';
      const finish_page = '{{ route('services.finish') }}';
      const buy_now_mode = '{{ $buy_now_mode ?? 0 }}';
  </script>
  <script src="{{ asset('js/checkout.js') }}"></script>

</x-guest-layout>
