@php
$subTotal = 0;
@endphp

@foreach ($products as $key => $product)
    @php
        $subTotal += $product->qty * $product->price;
        if (count($product->options)) {
          $variant_name = \App\Models\ProductsVariant::find($product->options->id)->variant_name;
        }
    @endphp
    <div class="cart-item mb-3">
        <div class="row">
            <div class="col-3">
                <img src="{{ $product->model->uploads->getImageOptimizedFullName() }}" alt=""
                    class="thumbnail border rounded w-100">
            </div>
            <div class="col-8">
                <div class="item-meta text-nowrap mb-2">
                    @if(count($product->options))
                        {{$product->name}} ( {{$variant_name}} )
                    @else
                        {{$product->name}}
                    @endif
                </div>
                <div class="item-meta mb-2"><span class="fw-800">Quantity:</span> {{ $product->qty }}</div>
            </div>
            <div class="col-1 text-right">
                <span class="text-primary fw-800">${{ number_format($product->price, 2, ".", ",") }}</span>
            </div>
        </div>
    </div>
@endforeach

<div class="cart-item mb-3 pt-3">
    <div class="row">
        <div class="col-6">
            <span class="fw-800">Sub Total</span>
        </div>
        <div class="col-auto ml-auto text-right">
            <span class="fw-800" id="spnSubTotalPrice">
                ${{ number_format($subTotal, 2, '.', ',') }}
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
            <span class="fw-800">Shipping</span>
        </div>
        <div class="col-auto ml-auto text-right">
            <span class="fw-800" id="shipping_price">
                $@php
                    $shippingPrice = Session::get('shipping_price', 0);
                    echo number_format($shippingPrice / 100, 2, ".", ",");
                @endphp
            </span>
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
                $@php
                    $taxPrice = 0;
                    foreach ($products as $product) {
                        $taxPrice += $product->qty * $product->price * $product->model->taxPrice();
                    }
                    echo number_format($taxPrice / 100 / 100, 2, ".", ",");
                @endphp
            </span>
        </div>
    </div>
</div>

@php
$total = $subTotal + $shippingPrice / 100 + $taxPrice / 100 / 100;
@endphp

<div class="cart-item mb-3">
    <div class="row">
        <div class="col-6">
            <span class="fw-800">Total</span>
        </div>
        <div class="col-auto ml-auto text-right">
            <span class="fw-800 text-primary" id="total_price">
                ${{number_format($total, 2, ".", ",")}}
            </span>
        </div>
    </div>
</div>

<script>
var taxPrice = {{ $taxPrice / 100 / 100 }};
var shippingPrice = {{ $shippingPrice / 100 }};
var subTotal = {{ $subTotal }};
var old_coupon_code = '';
var is_coupon_applied = false;

var currencyFormat = function(amount) {
    return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

$(document).ready(function() {
    $('body').on('click', '#btnApplyCoupon', function() {
        var coupon_code = $('#txtCouponCode').val();

        if (old_coupon_code == coupon_code) {
            return;
        }

        var data = {
            "_token": "{{ csrf_token() }}",
            "coupon_code": coupon_code,
        };

        $.ajax({
            url: "{{ route('checkout.check_coupon') }}",
            type: "POST",
            data: data,
            dataType: "json",
            success: (result) => {
                if (result.result == false) {
                    total = subTotal + shippingPrice + taxPrice ;

                    if (coupon_code.trim() == '') {
                        $('#txtCouponCode').removeClass('is-invalid');
                        $('#divCouponErrorMsg').html('').addClass('d-none');
                    } else {
                        $('#txtCouponCode').addClass('is-invalid');
                        $('#divCouponErrorMsg').html(result.message).removeClass('d-none');    
                    }

                    $('#spnDiscountPrice').html('');
                    $('#spnTaxPrice').html('$' + currencyFormat(taxPrice));
                    $('#spnTotalPrice').html('$' + currencyFormat(total));

                    $('#divCouponName').html('');
                    $('#divDiscount').addClass('d-none');

                    if (is_coupon_applied == true) {
                        loadStripeElement();
                        is_coupon_applied = false;
                    }

                    return false;
                }

                is_coupon_applied = true;
                loadStripeElement();

                $('#txtCouponCode').removeClass('is-invalid');
                $('#divCouponErrorMsg').html('').addClass('d-none');

                var coupon = result.coupon;
                var discount = 0;
                var tax_price = 0;
                if (coupon.type == 0) {
                    discount = coupon.amount;
                } else {
                    discount = subTotal * coupon.amount / 100;
                }

                var total_price = 0;
                if (subTotal < discount) {
                    tax_price = 0;
                    total_price = shippingPrice;
                } else {
                    tax_price = taxPrice * (subTotal - discount) / subTotal;
                    total_price = subTotal - discount + shippingPrice + tax_price;
                }
                
                $('#spnDiscountPrice').html('- $' + currencyFormat(discount));
                $('#divCouponName').html('Discount (' + coupon.name + ')');
                $('#divDiscount').removeClass('d-none');

                $('#spnTaxPrice').html('$' + currencyFormat(tax_price));
                $('#spnTotalPrice').html('$' + currencyFormat(total_price));
            },
            error: (resp) => {
                var result = resp.responseJSON;
                if (result.errors && result.message) {
                    alert(result.message);
                    return;
                }
            }
        });
        

        old_coupon_code = coupon_code;
    });
});
</script>