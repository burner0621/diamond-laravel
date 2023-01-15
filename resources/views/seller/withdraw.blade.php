<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>
  <div class="py-9">
      <div class="container">
          <div class="seller-dash-nav mb-4">
              <ul class="nav nav-pills">
                  <li class="nav-item">
                      <a class="nav-link {{ \Route::currentRouteName() == 'seller.dashboard' ? 'active' :'' }}" href="{{ route('seller.dashboard') }}">Seller Dashboard</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ \Route::currentRouteName() == 'dashboard' ? 'active' :'' }}" href="{{ route('dashboard') }}">User Dashboard</a>
                  </li>
              </ul>
          </div>
          <div class="row">
              <div class="col-3">
                  <x-dashboard-side-bar />
              </div>
              <div class="col-9">
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
                  <div class="seller-stats mb-4">
                      <div class="seller-stats-card-body">
                          <div class="row">
                              <div class="col-md-3">
                                  <div class="card m-0">
                                      <div class="card-header blance-title">Available To Withdraw</div>
                                      <div class="card-body">
                                          <p class="fw-bold">$ {{ number_format($withdrawable/100, 2, ".", ",") }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="card m-0 h-100">
                                      <div class="card-header blance-title">Wallet</div>
                                      <div class="card-body">
                                          <p class="fw-bold">$ {{ number_format($seller->wallet/100, 2, ".", ",") }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="card m-0 h-100">
                                      <div class="card-header blance-title">Total Earned</div>
                                      <div class="card-body">
                                          <p class="fw-bold">$ {{ number_format($totalEarned/100, 2, ".", ",") }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3"></div>
                          </div>
                          <form action="{{ route('seller.withdraw.post') }}" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    <div class="card col-md-12 mb-4">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title mb-0">Withdraw Money</h4>
                                        </div>
                                        <!-- End Header -->
                                        <div class="card-body">
                                            @include('includes.validation-form')
                                            <div class="mb-4">
                                                <label for="amount" class="w-100 mb-2">Amount:</label>
                                                <input type="number" name="amount" id="amount" max="{{$withdrawable}}" step="0.01" min="0.01" value="{{ old('amount') }}" class="form-control" required>
                                            </div>
                                 
                                            <div class="mb-4 col-12">
                                                <label for="method" class="w-100 mb-2">Payment Method</label>
                                                <div class="col-4">
                                                    <select class="form-control" id="method" name="method" data-live-search="true" data-container="body">
                                                        @foreach ($payment_methods as $method)
                                                            <option value="{{$method->id}}" data-id="{{$method->id}}">{{$method->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col mb-5" id="questions">
                                            </div>

                                            <button type="submit" class="btn btn-primary">Withdraw</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </form>
                      </div>
                  </div>
              </div> <!-- end .col-9 -->
          </div> <!-- .row -->
      </div>
  </div>

  <script>
    var paymentMethods = {!! $payment_methods !!};
    $(function () {
      $('#method').change(function () {
        var selected = $(this).val();
        
        selectedMethod(selected);
      })

      selectedMethod(paymentMethods[0].id);
    })

    function selectedMethod(id) {
        $('#questions').empty();
        
        const payment = paymentMethods.filter((item) => item.id == id)[0];
        for(var i = 0; i < 4; i++) {
          if (payment[`question_${i+1}`]) {
            $('#questions').append(`<div class="mb-2">
                                      <input type="hidden" name="question[]" value="${i}">
                                      <label for="answer" class="w-100 mb-2">${payment[`question_${i+1}`]}</label>
                                      <input type="string" name="answer[]" class="form-control" required>
                                    </div>`);
          }
        }
    }
  </script>
</x-app-layout>
