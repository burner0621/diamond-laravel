<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-9">
      <div class="container">
          <div class="row">
              <div class="col-lg-4">
                  <div class="card py-3">
                      <div class="card-body">
                          <h4 class="card-title">{{ $carts }} Products</h4>
                          <h6 class="card-subtitle mb-2 text-muted">in your cart</h6>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="card py-3">
                      <div class="card-body">
                          <h4 class="card-title">{{ $wishlists }} Products</h4>
                          <h6 class="card-subtitle mb-2 text-muted">in your wishlist</h6>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="card py-3">
                      <div class="card-body">
                          <h4 class="card-title">{{ $orders }} Products, {{ $service_orders }} Services, {{ $course_orders }} Courses</h4>
                          <h6 class="card-subtitle mb-2 text-muted">you ordered</h6>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">Your Purchases</div>
                    <div class="card-body">
                        <div class="card-body-content">
                            @foreach ($purchases as $item)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                @if ($item->product_variant == 0)
                                                    <a href="{{ route('orders.show', $item->order_id) }}">
                                                        <img src="{{ $item->uploads->getImageOptimizedFullName(400) }}"
                                                            alt="{{ $item->product_name }}" class="w-100 border">
                                                    </a>
                                                @else
                                                    <a href="{{ route('orders.show', $item->order_id) }}">
                                                        <img src="{{ $item->uploads->getImageOptimizedFullName(400) }}"
                                                            alt="{{ $item->product_name }} - {{ $item->product_variant_name }}" class="w-100 border">
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                @if ($item->product_variant == 0)
                                                    <a href="{{ route('orders.show', $item->order_id) }}" class="fw-600 text-black">
                                                        <h6>{{ $item->product_name }}</h6>
                                                    </a>
                                                @else
                                                    <a href="{{ route('orders.show', $item->order_id) }}" class="fw-600 text-black">
                                                        <h6>{{ $item->product_name }} - {{ $item->product_variant_name }}</h6>
                                                    </a>
                                                @endif
                                            </div>
                                            
                                            <div class="col-4">
                                                <a href="{{ route('orders.show', $item->order_id) }}" class="btn btn-primary mb-2 w-100">View</a>
                                                <a href="{{ route('orders.show', $item->order_id) }}" class="btn btn-danger w-100">Create</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{$purchases->appends(Arr::except(Request::query(), 'product'))->links()}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">Your Service Orders</div>
                    <div class="card-body">
                        <div class="card-body-content">
                            @foreach ($services as $item)
                                @isset($item->service)
                                    @isset($item->service->uploads)
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <a href="/services/order/{{$item->order_id}}" class="fw-600 text-black">
                                                            <img src="{{ $item->service->uploads->getImageOptimizedFullName(400) }}"
                                                    alt="{{ $item->service->name }} - {{ $item->package_name }}" class="w-100 border">
                                                        </a>
                                                    </div>
                                                    <div class="col-4">
                                                        <a href="/services/order/{{$item->order_id}}" class="fw-600 text-black">
                                                            <h6>{{ $item->service->name }}</h6>
                                                            <h6>Package: {{ $item->package_name }} / ${{number_format($item->package_price / 100, 2)}}</h6>
                                                            <h6>Status: @if ($item->status == 0)
                                                                Pending Requirements
                                                                @elseif ($item->status == 1)
                                                                Pending
                                                                @elseif ($item->status == 2)
                                                                Revision
                                                                @elseif ($item->status == 3)
                                                                Cancelled</span>
                                                                @elseif ($item->status == 4)
                                                                <span>Delivered</span>
                                                                @elseif ($item->status == 5)
                                                                <span>Completed</span>
                                                                @endif
                                                            </h6>
                                                        </a>
                                                    </div>
                                                    <div class="col-4">
                                                        <a href="/services/order/{{$item->order_id}}" class="btn btn-primary w-100">View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endisset
                                @endisset
                            @endforeach
                        </div>
                        {{$services->appends(Arr::except(Request::query(), 'service'))->links()}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">Your Course Orders</div>
                    <div class="card-body">
                        <div class="card-body-content">
                            @foreach ($courses as $item)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <a href="/courses/course/{{ $item->course->slug }}" class="fw-600 text-black">
                                                    <img src="{{ $item->course->uploads->getImageOptimizedFullName(400) }}" alt="{{ $item->course->name }}" class="w-100 border">
                                                </a>
                                            </div>
                                            <div class="col-4">
                                                <a href="/courses/course/{{ $item->course->slug }}" class="fw-600 text-black">
                                                    <h6>{{ $item->course->name }}</h6>
                                                </a>
                                            </div>
                                            <div class="col-4">
                                                <a href="/courses/course/{{ $item->course->slug }}" class="btn btn-primary w-100">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{$courses->appends(Arr::except(Request::query(), 'course'))->links()}}
                    </div>
                </div>
            </div>

          </div>
      </div>
  </div>
</x-app-layout>
