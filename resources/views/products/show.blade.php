<x-app-layout page-title="{{$product->meta_title?$product->meta_title:$product->name}}"
              page-description="{{$product->meta_description}}">
    <style>
        .btn-check:active + .btn, .btn-check:checked + .btn, .btn.active, .btn.show, .btn:active {
            border: solid 1px white !important;
        }

        .min-w-50 {
            min-width: 50px;
        }

    </style>

    <section class="product_detail_single">
        <div class="container">
            <div class="product-container col-lg-8 col-md-10 py-9 mx-auto checkout-wrap">
                <div class="product-details-meta-block align-items-center mb-4 col-lg-10 mx-auto row">
                    <div class="col-lg-6 col-12 px-0 py-3">
                        <div class="d-flex align-items-center">
                            <a href="/u/{{$product->user->username}}">
                                <img id="fileManagerPreview"
                                     src="{{ $product->user->uploads->getImageOptimizedFullName(200,200) }}"
                                     class="product-seller rounded-circle h-60px mr-5px">
                            </a>
                            {{-- <img src="https://jewelrycg.com/assets/img/avatar.png" class="product-seller rounded-circle h-60px mr-5px" /> --}}
                            <div class="product-details-title px-2">
                                <div class="fs-20 fw-600">{{ $product->name }}</div>
                                <div class="link">
                                    <span><a href="/u/{{$product->user->username}}">{{$product->user->username}}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto col-12 ml-auto p-0">
                        <div class="product-details-price">
                            <div class="w-100">

                                @if(Auth::id() != $product->vendor)
                                    <a class="btn btn-primary"
                                       href="{{route('create_chat_room',['conversation_id'=>$product->vendor])}}">Message</a>
                                @endif
                                <a class="btn btn-primary product_price" href="#">
                                    <i class="bi bi-cart-plus p-1"></i>
                                    @if (count($variants))
                                        @if($minPrice != $maxPrice)
                                            ${{ number_format($minPrice, 2, ".", ",") }} ~
                                            ${{ number_format($maxPrice, 2, ".", ",") }}
                                        @else
                                            ${{ number_format($minPrice, 2, ".", ",") }}
                                        @endif
                                    @else
                                        ${{ $product->price }}
                                    @endif
                                </a>

                                @auth
                                    @if ($wishlist_product = Cart::instance('wishlist')->content()->firstWhere('id', $product->id))
                                        <form action="{{route('wishlist')}}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="row_id" value="{{ $wishlist_product->rowId }}">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-heart-fill p-1"></i>
                                                Saved
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{route('wishlist')}}" method="post" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id_product" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-light">
                                                <i class="bi bi-heart p-1"></i>
                                                Save
                                            </button>
                                        </form>
                                    @endif




                                    <div class="modal fade" id="messageModal" tabindex="-1"
                                         aria-labelledby="messageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="messageModalLabel">Send message to
                                                        seller</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="message" class="form-label">Input message here</label>
                                                    <textarea id="message" class="form-control"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <button type="button" class="btn btn-primary"
                                                            data-bs-dismiss="modal" id="send-message">Send
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @if ($product->modelpreview->file_name != 'none.png')
                    <div class="product-3dmodel bg-white mb-4">
                        <div class="model-box border rounded h-500px p-2">
                            <model-viewer class="model-full-hw" alt="{{ $product->name }} Preview"
                                          src="{{ asset('uploads/all/') }}/{{ $product->modelpreview->file_name }}"
                                          poster="{{ asset('assets/img/placeholder.jpg') }}" ar-scale="auto"
                                          poster="assets/img/placeholder.jpg" loading="lazy"
                                          camera-orbit="{{$product->product_3dpreview_xyz}}"
                                          ar-modes="webxr scene-viewer quick-look" shadow-intensity="0" camera-controls
                                          auto-rotate></model-viewer>
                        </div>
                    </div>
                @endif
                <!-- Product Images/Preview -->
                <div class="product-gallery-thumb row mb-2">
                    @foreach ($uploads as $key => $image)
                        @if ($key < 3)
                            <div class="carousel-box c-pointer col-6 col-lg-6 mb-3">
                                <img src="{{ asset('uploads/all/') }}/{{ $image->file_name }}"
                                     class="mw-100 mx-auto border rounded" alt="{{ $key }}">
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="row">

                    <!-- Product Details/Title -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="bg-white p-3 mb-0">
                            <div class="product-details-misc border-bottom pb-2 mb-4">
                                <div class="col-6 text-left">
                                    <ul class="list-inline social fw-600 mb-0">
                                        <li class="list-inline-item">
                                            <a target="_self" href="mailto:?subject={{ $product->name }}&amp;body=#"
                                               class="jssocials-share-link text-black fs-18">
                                                <i class="bi bi-envelope fs-20"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_blank"
                                               href="https://twitter.com/share?url=#&amp;text={{ $product->name }}"
                                               class="jssocials-share-link text-black fs-18">
                                                <i class="bi bi-twitter fs-20"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=#"
                                               class="jssocials-share-link text-black fs-18">
                                                <i class="bi bi-facebook fs-20"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_blank"
                                               href="https://www.linkedin.com/shareArticle?mini=true&amp;url=#"
                                               class="jssocials-share-link text-black fs-18">
                                                <i class="bi bi-linkedin fs-20"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a target="_self" href="whatsapp://send?text=#"
                                               class="jssocials-share-link text-black fs-18">
                                                <i class="bi bi-whatsapp fs-20"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details-misc mb-4">
                                {{ $product->description }}
                            </div>

                            @if ($product->is_backorder)
                                <div class="alert alert-info mt-2" role="alert">
                                    This product is available on backorder and will be shipped when back in stock.
                                </div>
                            @endif

                            @if ($product->is_madetoorder)
                                <div class="alert alert-info mt-2" role="alert">
                                    This product is made to order.
                                </div>
                            @endif

                            <div class="product-details-price mb-4">
                                <div class="w-100">
                                    <div class="opacity-50 my-2">Price:</div>
                                </div>
                                <div class="w-100">
                                    <div class="">
                                        <strong class="h2 fw-400 text-black product_price">
                                            @if (count($variants))
                                                @if($minPrice != $maxPrice)
                                                    ${{ number_format($minPrice, 2, ".", ",") }} ~
                                                    ${{ number_format($maxPrice, 2, ".", ",") }}
                                                @else
                                                    ${{ number_format($minPrice, 2, ".", ",") }}
                                                @endif
                                            @else
                                                ${{ $product->price }}
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="product-details-misc mb-4">

                                <h4>

                                    @if ($product->is_trackingquantity)
                                        @if ($product->quantity)
                                            <span class="badge badge-lg bg-success text-light rounded-pill"><small>On
                                                    Stock: {{ $product->quantity }}</small></span>
                                        @else
                                            <span class="badge badge-lg bg-danger text-light rounded-pill"><small>Out of
                                                    Stock</small></span>
                                        @endif
                                    @endif
                                </h4>
                            </div>

                            {{-- if {sc:cart:alreadyExists :product="id"} == true --}}
                            <!--
                            <div class="border-t border-gray-200 py-4 flex justify-between items-center">
                                <span class="font-medium">This product is already in your cart.</span>

                                <a class="bg-green-100 hover:opacity-75 text-gray-700 font-semibold rounded-lg px-4 py-2" href="/cart">
                                    View Cart
                                </a>
                            </div>
                            -->
                            {{-- else --}}

                            @if (session('message'))
                                <div class="text-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <form action="{{ route('cart.store') }}" method="post" class="my-3"
                                  name="cart_star_form" id="cart_star_form">
                                @csrf

                                <input type="hidden" name="variant_attribute_value" id="variant_attribute_value"
                                       value="0">
                                @if (count($variants) > 0)
                                    <div class="variant-group mb-2">
                                        @foreach ($product->attribute() as $attribute)
                                            <div class="form-group mb-2">
                                                <label for=""
                                                       class="control-label opacity-50 my-2">{{ $attribute->name }}
                                                    :</label>
                                                <div class="col-md-10 mt-1">
                                                    <div class="variants-btn-group" data-toggle="buttons"
                                                         id="variants_group">
                                                        @foreach ($product->attributeValue($attribute->id) as $attributeValue)
                                                            @if ($attribute->type == 1)
                                                                <!-- color type -->
                                                                <input type="radio"
                                                                       class="attribute-radio btn-check attribute{{ $attribute->id }}"
                                                                       name="attribute{{ $attribute->id }}"
                                                                       data-attribute-id="{{ $attribute->id }}"
                                                                       value="{{ $attributeValue->id }}"
                                                                       id="attributeValue{{$attributeValue->id}}"
                                                                       autocomplete="off">
                                                                <label class="btn btn-secondary me-2"
                                                                       for="attributeValue{{$attributeValue->id}}"
                                                                       style="background-color:{{$attributeValue->value}};border-color: white;border-radius: 50%;height: 50px;width: 50px;"></label>
                                                            @endif
                                                            @if ($attribute->type == 2)
                                                                <!-- image type -->
                                                                <input type="radio"
                                                                       class="attribute-radio btn-check attribute{{ $attribute->id }}"
                                                                       name="attribute{{ $attribute->id }}"
                                                                       data-attribute-id="{{ $attribute->id }}"
                                                                       value="{{ $attributeValue->id }}"
                                                                       id="attributeValue{{$attributeValue->id}}"
                                                                       autocomplete="off">
                                                                <label class="btn btn-secondary me-2 p-0"
                                                                       for="attributeValue{{$attributeValue->id}}"
                                                                       style="border: solid grey 1px;height: 52px;width: 52px;background-color: transparent;">
                                                                    <img src="{{$attributeValue->image->getImageOptimizedFullName(50, 50)}}"
                                                                         class="" style="border-radius: 6px;"/>
                                                                </label>
                                                            @endif
                                                            @if ($attribute->type == 0)
                                                                <!-- select type -->
                                                                <input type="radio"
                                                                       class="attribute-radio btn-check attribute{{ $attribute->id }}"
                                                                       name="attribute{{ $attribute->id }}"
                                                                       data-attribute-id="{{ $attribute->id }}"
                                                                       value="{{ $attributeValue->id }}"
                                                                       id="attributeValue{{$attributeValue->id}}"
                                                                       autocomplete="off">
                                                                <label class="btn btn-outline-primary me-2"
                                                                       for="attributeValue{{$attributeValue->id}}">{{$attributeValue->name}}</label>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <input type="hidden" name="id_product" value="{{ $product->id }}">
                                <button class="btn btn-primary shadow-md add-to-cart mt-4 d-none" type="submit"
                                        {{ ($product->is_trackingquantity == 1 && $product->quantity < 1) || count($variants) > 0 ? 'disabled' : null }}  id="add_to_cart_btn">
                                    <div class="loader-container">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                              aria-hidden="true"></span>
                                        Adding ...
                                    </div>
                                    <div class="orginal-name">Add to Cart</div>
                                </button>
                                <a id="view_order_btn" class="btn btn-primary shadow-md add-to-cart mt-4 d-none"
                                   href="{{ route('orders.index') }}">
                                    <div class="orginal-name">View Order</div>
                                </a>

                                <!--<button type="submit" formaction="{{ route('cart.buy.now') }}"
                                    class="btn btn-success shadow-md mt-4"
                                    {{ ($product->is_trackingquantity == 1 && $product->quantity < 1) || count($variants) > 0 ? 'disabled' : null }}
                                id="buy_now_btn">Buy Now</button>
                                -->

                            </form>
                        </div>

                        @include('products.show_materials')
                    </div>
                </div>

                @if(isset($arrProductDiamonds) && count($arrProductDiamonds) > 0)
                    @include('products.show_diamonds')
                @endif

                @if (count($arrProductMaterials))
                    @include('products.show_step_cal')
                @endif

                @include('products.show_steps')

                @if ($product_reviewable)
                    <div class="card">
                        <form id="frmRate" method="POST" action="{{ route('products.add_review') }}">
                            @csrf
                            <div class="fs-18 py-2 fw-600 card-header">Rating</div>
                            <div class="card-body">
                                <div class="rate pb-1">
                                    @for ($i = 5; $i > 0; $i--)
                                        <input
                                            type="radio" id="star{!! $i !!}" class="rate" name="rating"
                                            value="{!! $i !!}"
                                            {{ $user_product_review?->rating == $i ? "checked" : "" }}
                                        />
                                        <label for="star{!! $i !!}" class="d-flex relative">
                                            <img src="/assets/img/star_blue.png" width="25" class="label-check absolute d-none"/>
                                            <img src="/assets/img/star_gray.png" width="25" class="label-not-check"/>
                                        </label>
                                    @endfor
                                </div>
                                @if ($user_product_review)
                                    <div class="clearfix"></div>
                                    <div class="rated_date pb-2">Rated at {{ $user_product_review->updated_at }}</div>
                                @endif

                                <div class="clearfix"></div>

                                <div>
                                    <label>Review Comment</label>
                                    <textarea name="review" id="txtReview" rows="4" class="form-control" required
                                    >{{ $user_product_review?->review }}</textarea>
                                </div>

                                <div class="text-right py-3">
                                    @if ($user_product_review)
                                        <button type="submit" class="btn btn-sm btn-primary">Update Review</button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-primary">Add Review</button>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>
                    </div>
                @endif

                <div class="section-header">
                    <div class="section-header-title mb-3 text-uppercase fw-700 border p-3 card rounded">Reviews</div>
                </div>
                @if ($review_count > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="star-ratings me-auto ml-auto">
                                    <div class="relative">
                                        <div class="fill-ratings" style="width: {{ $average_rating * 150 / 5 }}px;">
                                            <img src="/assets/img/star_fill.png" width="150"/>
                                        </div>
                                        <div class="empty-ratings">
                                            <img src="/assets/img/star_empty.png" width="150"/>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="text-black fs-30 fw-700">{{ $average_rating }}</h1>
                                <p>based on {{ $review_count }} reviews</>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div id="review_listing">
                                @include('products.show_reviews')
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <p class="text-left mb-0">No reviews posted.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- data-bs-scroll="true" --}}
    <div class="offcanvas offcanvas-end cart-drawer-panel" tabindex="-1" id="cartDrawer"
         aria-labelledby="cartDrawerLabel">
        <div class="offcanvas-header cart-drawer-header">
            <h5 class="offcanvas-title" id="cartDrawerLabel">Cart</h5>
            <button type="button" class="btn text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body cart-drawer-content py-4"></div>
    </div>


    @if (session('wishlist-message'))
        {{-- <h4 class="text-center text-success">
            {{ session('wishlist-message') }}
        </h4> --}}
    @endif

    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#frmRate').submit(function () {
          if ($('.rate:checked').length == 0) {
            alert('Please rate the product');
            return false;
          }
        });

        $('body').on('click', '.pagination a', function (e) {
          var url = $(this).attr('href');
          $.ajax({
            url: url,
            success: function (result) {
              $('#review_listing').html(result);
            }
          });
          e.preventDefault();
        });
      });

      var variants = [];
      $('.loader-container').hide();

      @foreach ($variants as $variant)
      var ids = '{{ $variant->variant_attribute_value }}';
      ids = ids.split(',');

      variants.push({
        id: ids.sort().join(','),
        price: '{{ $variant->variant_price }}'
      })
      @endforeach

      $('.attribute-radio').click(function () {
        var selectedAttributeValue = [];
        var selectedAttributeCount = 0;

        $('.variant-group').find('div.form-group').each(function (i, div) {
          var name = $(div).find('input').attr('name');
          var value = document.cart_star_form[name].value
          selectedAttributeCount++;

          if (value)
            selectedAttributeValue.push(value)
        })

        if (selectedAttributeValue.length == selectedAttributeCount) {
          $('#buy_now_btn, #add_to_cart_btn').removeAttr('disabled');
        }

        variants.forEach(function (variant) {
          if (variant.id == selectedAttributeValue.sort().join(',')) {
            $('#variant_attribute_value').val(variant.id)
            $('.product_price').text('$' + parseFloat((variant.price / 100).toFixed(2)).toLocaleString())
          }
        })

        onVariantClick($(this).val());

        $('.item-value-card-wrapper').addClass('d-none')
        $('.item-value-card-wrapper[data-attribute-id="' + this.dataset.attributeId + '"][data-attribute-value-id="' + this.value + '"]').removeClass('d-none')

        $('.diamond').addClass('d-none')
        $('.diamond[data-product-attribute-value-id="' + this.value + '"]').removeClass('d-none')
      });

      var purchaseInfo = {!!$purchaseInfo!!};

      if (variants.length == 0 && purchaseInfo.length > 0 && purchaseInfo[0].count > 0) {
        $("#add_to_cart_btn").addClass("d-none");
        $("#view_order_btn").removeClass("d-none");
      } else {
        $("#add_to_cart_btn").removeClass("d-none");
        $("#view_order_btn").addClass("d-none");
      }

      var onVariantClick = function (variant) {
        $("#add_to_cart_btn").addClass("d-none");
        $("#view_order_btn").addClass("d-none");
        for (var i in purchaseInfo) {
          if (purchaseInfo[i].variant_attribute == variant && purchaseInfo[i].count > 0) {
            $("#view_order_btn").removeClass("d-none");
            return;
          }
        }
        $("#add_to_cart_btn").removeClass("d-none");
      }

      document.cart_star_form.onsubmit = function () {
        var data = {};
        var formData = $('#cart_star_form').serializeArray();
        formData.map(function (item) {
          data[item.name] = item.value;
        });

        $('.orginal-name').hide();
        $('.loader-container').fadeIn();

        $.ajax({
          url: "{{ route('cart.store') }}",
          method: 'post',
          data: data,
          success: function (data) {
            $('.loader-container').hide();
            $('.orginal-name').fadeIn();

            $.ajax({
              url: "{{ route('cart.count') }}",
              method: 'get',
              success: function (count) {
                $('.cart-count').html(
                  '<span class="cart-count-number">' +
                  count + '</span>');
              }
            });

            $('.cart-drawer-content').html(data);
            var cartDrawer = new bootstrap.Offcanvas(document.getElementById(
              'cartDrawer'));
            cartDrawer.show();
          }
        })

        return false;
      }

      if ($('.attribute-radio').length)
        $('.attribute-radio')[0].click()
    </script>
    <script>
      (function () {
        $('#send-message').click(async function () {
          var message = $('#message').val();

          if (message.length > 0) {

            $('#message').val();
          }
        })
      })();
    </script>
</x-app-layout>
