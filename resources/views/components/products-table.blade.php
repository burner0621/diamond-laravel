<div class="product-container">
    @foreach ($products as $key => $product)
        <div class="cart-item mb-3 product-item">
            <div class="row">
                <div class="col-lg-2 col-4">
                    <img src="{{ $product->model->uploads->getImageOptimizedFullName(250) }}" alt="" class="thumbnail border rounded w-100">
                </div>
                <div class="col-lg-10 col-8">
                    <div class="item-meta mb-3 fw-800 fs-18">
                        @php
                            if (count($product->options)) {
                                echo $product->name . ' ( ' . \App\Models\ProductsVariant::find($product->options->id)->variant_name.' )';
                                // echo $product->name;
                            } else {
                                echo $product->name;
                            }
                        @endphp
                    </div>
                    <div class="item-meta mb-2">
                        <span class="text-primary fw-800 mb-2" id="price{{ $product->rowId }}">${{ number_format($product->price, 2, ".", ",") }}</span>
                    </div>
                    @if ($locale == 'wishlist')
                    <div class="item-meta mb-2">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-1">View Product</a>
                    </div>
                    @endif
                    @if ($locale == 'cart')
                        <div class="item-meta mb-2 row align-items-baseline">
                            <div class="col-auto">
                                <span class="fw-800">Quantity:</span> 
                            </div>
                            <div class="col-auto">
                                <input type="number" value="{{ $product->qty }}" placeholder="{{ $product->qty }}" name="quantity" min="1" max="100" class="form-control quantity" data-id="{{ $product->rowId }}" data-price="{{ $product->price }}" id="{{ $product->rowId }} inlineFormInputGroup">
                                <?php $out_of_stock[$key] = $product->qty > $product->model->quantity && $product->model->is_trackingquantity; ?>
                                @if ($out_of_stock[$key])
                                    <div class="col-2">
                                        <span class="badge rounded-pill text-light bg-danger">
                                            In Stock: {{ $product->model->quantity }}
                                        </span>
                                    </div>
                                @endif
                                @csrf
                            </div>
                        </div>
                        <div class="item-meta mb-2">
                            <div class="text-left">
                                <a href="{{ url('cart/remove') . '/' . $product->rowId }}" class="text-danger" title="Remove from chart">Remove</a>
                            </div>
                        </div>
                    @else
                        <!-- {{ $product->qty }} -->
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="rowf">
    <div class="row">
        @if ($locale == 'cart')
        <div class="col-2 fw-700">Total:</div>
        <div class="col-10"><span class="total-price">${{ Cart::total() }}</span></div>
        @else
            <span class="total-price mr-10px">
                {{-- number_format(Cart::total() + $shippingPrice / 100 + $taxPrice / 10000, 2) --}}
            </span>
        @endif
        @if ($locale == 'cart' && $products->count() > 0)
        <div class="col-12">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary float-right mt-4 w-100 {{ isset($out_of_stock) && in_array(true, $out_of_stock) ? 'disabled' : null }}">Proceed to Checkout</a>
        </div>
        @endif

    </div>
</div>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    $('.quantity').change(function() {
        
        var quantity = $(this).val();
        var rowId = $(this).attr('data-id');
        var price = $(this).attr('data-price');
        var total = price * quantity

        $.ajax({
            method: 'post',
            url: "{{ route('cart.edit.qty') }}",
            data: {
                row_id: rowId,
                quantity: quantity
            },
            success: function(data) {
                total = 0;

                $('.product-container').find('div.product-item').each(function () {
                    var price = $(this).find('input.quantity').attr('data-price');
                    var quantity = $(this).find('input.quantity').val();

                    total += price * quantity;
                });

                $('span.total-price').text('$' + (Math.round(total * 100) / 100).toFixed(2));
            }
        })

    })
</script>
