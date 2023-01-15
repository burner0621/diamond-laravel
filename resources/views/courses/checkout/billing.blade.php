<x-guest-layout page-title="Shipping Detail">
    <div class="checkout-container">
        <div class="checkout-wrap">
            <div class="row">
                <div class="col-lg-6">
                    <div class="col-xl-8 col-lg-10 ml-auto p-3">
                        <div class="logo py-4 fw-800 fs-24">#JEWELRYCG</div>
                        <nav class="pb-4" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/courses/course/{{ $course->slug }}">Course</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Billing</li>
                                <li class="breadcrumb-item" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                        <form action="/courses/checkout/{{ $course->id }}" method="POST" id="frmBilling">
                            @csrf
                            <div class="checkout-card">
                                <div class="checkout-card-body">
                                    <h3 class="mb-3 fs-20">Billing Address</h3>
                                    @include('includes.validation-form')
                                    <x-user-info :countries="$countries" :billing="$billing" :location="$location"/>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            @if (auth()->id())
                                                <label for="isRemember">
                                                    <input type="checkbox" name="isRemember" id="isRemember">
                                                    @if($billing !== "NULL") 
                                                        Update Address
                                                    @else
                                                        Remember Address
                                                    @endif
                                                </label>
                                            @endif
                                            <input type="hidden" value="{{ isset($orderId) ? $orderId : 0 }}" />
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
                                <div class="cart-item mb-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{ $course->uploads->getImageOptimizedFullName(150) }}" alt="thumb" class="thumbnail border rounded w-100">
                                        </div>
                                        <div class="col-8">
                                            <div class="item-meta text-nowrap mb-2">
                                                {{ $course->name }}
                                            </div>
                                            <div class="item-meta mb-2"><span class="fw-800">Price:</span> {{ number_format($course->price/100, 2) }}</div>
                                            <div class="item-meta mb-2"><span class="fw-800">Lessons:</span> {{ count($course->lessons) }}</div>
                                        </div>
                                        <div class="col-1 text-right">
                                            <span class="text-primary fw-800">${{ number_format($course->price/100, 2, ".", ",") }}</span>
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
                                                ${{ number_format($course->price/100, 2, '.', ',') }}
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
                                                ${{number_format($course->price/100, 2, ".", ",")}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end row -->
        </div><!-- end checkout-wrap -->
    </div><!-- end container -->
</x-guest-layout>
