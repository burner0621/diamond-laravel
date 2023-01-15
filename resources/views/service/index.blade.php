<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-9">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                <div class="p-6 mb-4 text-center border rounded">
                  <h3>Services</h3>
                </div>
                <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-1">
                  @foreach ($services as $service)
                  <div class="col mb-2 mb-lg-0">
                    <div class="border">
                      <div class="card-body p-3">
                        <div class="row">
                          <div class="col-4">
                            <a href="/services/{{$service->slug}}" class=""">
                              <img src="{{ $service->uploads->getImageOptimizedFullName(400,400) }}" class="rounded w-100 border" alt="{{ $service->name }}">
                            </a>
                          </div>
                          <div class="col-8">
                            <div class="fs-20 fw-500 mb-2">
                              <a href="/services/{{$service->slug}}" class="mt-2 text-black">{{ $service->name }}</a>
                            </div>
                            @foreach ($service->categories as $item)
                            <div class="fs-14 mb-2 fw-700">{{ $item->category->category_name }}</div>
                            @endforeach

                            @if ($service->count > 0)
                              <span><i class="bi bi-star-fill fs-18 text-warning"></i> {{ $service->rating ?: "0.0" }}</span>
                              <span class="text-secondary">({{$service->count}})</span>
                            @endif
                            
                          </div>
                        </div>
                      </div>
                      <div class="card-footer border-top bg-white p-3">
                      <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                              <div class="mr-5px">
                                <img class="w-20px rounded-circle" src="{{ $service->postauthor->uploads->getImageOptimizedFullName(100,100) }}" alt="{{ $service->postauthor->first_name }}">
                              </div>
                              <a href="u/{{ $service->postauthor->username }}" class="col- fs-14 fw-700">{{ $service->postauthor->username }}</a>
                            </div>
                        </div>
                        <div class="col-6">
                          <div class="text-right">Starting at <span class="fw-700 fs-18 text-primary">{{ count($service->packages) ? "$".($service->packages[0]->price / 100) : "..." }}</span></div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
