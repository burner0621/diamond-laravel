<x-app-layout page-title="My Orders">
  <div class="container">
      <div class="col-lg-8 col-md-10 py-8 mx-auto checkout-wrap">
        @if (session('success'))
          <h4 class="text-center text-primary mt-3">
              {{session('success')}}
          </h4>
        @endif
        @if (session('error'))
          <h4 class="text-center text-danger mt-3">
              {{session('error')}}
          </h4>
        @endif
        <form action="{{ route('services.review.post') }}" method="post" enctype="multipart/form-data">
          <div class="row">
              <div class="col-md-12">
                  @csrf
                  <div class="card col-md-12 mb-4">
                      <!-- Header -->
                      <div class="card-header">
                          <h4 class="card-header-title mb-0">Leave review to Order #{{$order->order_id}}</h4>
                          <input type="hidden" name="order_id" value="{{ $order->id }}">
                      </div>
                      <!-- End Header -->
                      <div class="card-body">
                          @include('includes.validation-form')
                          <div class="rate pb-3">
                            @for ($i = 5; $i > 0; $i--)
                                <input
                                    type="radio" id="star{!! $i !!}" class="rate" name="rating" value="{!! $i !!}"/>
                                <label for="star{!! $i !!}">{{ $i }}</label>
                            @endfor
                          </div>
               
                          <div class="mb-4 col-12">
                              <label for="method" class="w-100 mb-2">Review comment</label>
                              <textarea name="review" class="form-control"></textarea>
                          </div>

                          <button type="submit" class="btn btn-primary">Save Review</button>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
  </div>
  </x-app-layout>