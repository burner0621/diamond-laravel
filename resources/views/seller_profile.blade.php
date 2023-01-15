<x-app-layout>
  <section class="py-9">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src="{{ $seller->user->uploads->getImageOptimizedFullName(150,150) }}" alt="avatar"
                class="rounded-circle img-fluid border">
              <h5 class="my-3">{{ $seller->user->first_name . " " . $seller->user->last_name }}</h5>
              <p class="text-muted mb-1">{{ $seller->user->username }}</p>
              <p class="text-muted mb-4">{{ $seller->slogan }}</p>
              @if ($rating->count > 0)
              <div class="mb-3">
                <span><i class="bi bi-star-fill fs-20 text-warning"></i> {{ $rating->rating ?: "0.0" }}</span>
                <span class="text-secondary">({{$rating->count}})</span>
              </div>
              @endif
              <div class="d-flex justify-content-center mb-2">
                <a class="btn btn-primary" href="{{route('create_chat_room',['conversation_id'=>$seller->user->id])}}">Message</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="seller-products-card">
            <div class="seller-products-card-header fs-20 fw-700 mb-3">Our Products</div>
            <div class="seller-products-card-body">
              <div class="row">
                    @foreach ($products as $product)
                        @if ($product->status === 1)
                            <div class="mb-4 col-lg-3">
                                <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                      <img src="{{ $product->uploads->getImageOptimizedFullName(400,400) }}" alt="{{ $product->name }}" class="border w-100 mb-3 img-fluid">
                                    </a>
                                    <h5>{{ $product->name }}</h5>
                                    <!--
                                    <p class="text-muted mb-1">{{ $product->description }}</p>
                                    <p class="text-muted mb-4">{{ $product->product_category->name }}</p>
                                    -->
                                </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
              </div>
              {{$products->appends(Arr::except(Request::query(), 'product'))->links()}}
            </div>
          </div>
          <div class="seller-services-card">
            <div class="seller-services-card-header fs-20 fw-700 mb-3">Our Services</div>
            <div class="seller-services-card-body">
              <div class="row">
                @foreach ($services as $service)
                    @if ($service->status === 1)
                        <div class="mb-4 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                            <a href="/services/{{$service->slug}}">
                              <img src="{{ $service->uploads->getImageOptimizedFullName(400,400) }}" alt="{{ $service->name }}" class="border w-100 mb-3 img-fluid">
                            </a>
                            <h5>{{ $service->name }}</h5>
                            <!--
                            <p class="text-muted mb-1">{{ $service->description }}</p>
                            <p class="text-muted mb-4">{{ join(',' , array_map(function ($item) {return $item['category']['category_name'];}, $service->categories->toArray())) }}</p>
                            -->
                            </div>
                        </div>
                        </div>
                    @endif
                @endforeach
              </div>
              {{$services->appends(Arr::except(Request::query(), 'service'))->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</x-app-layout>
