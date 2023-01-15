<x-app-layout>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <div class="service-container col-lg-8 col-md-10 py-9 mx-auto">
        <div class="container">
            <div class="col-xl-10 mx-auto">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <a href="/u/{{ $service->postauthor->username }}">
                                    <img id="fileManagerPreview" src="{{ $service->postauthor->uploads->getImageOptimizedFullName(30,30) }}" class="product-seller rounded-circle h-60px mr-5px">
                                </a>

                                <div class="product-details-title px-2">
                                    <div class="fs-20 fw-600">{{$service->name}}</div>
                                    <div class="link">
                                        <span class="mr-10px d-none"><a href="/u/{{ $service->postauthor->username }}">{{ $service->postauthor->username }}</a></span>
                                        @if ($service->count > 0)
                                        <span><i class="bi bi-star-fill fs-20 text-warning"></i> {{ $service->rating ?: "0.0" }}</span>
                                        <span class="text-secondary">({{$service->count}})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel mb-6">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @for ($i = 0; $i < count($service->galleries); ++$i)
                                        <div class="carousel-item {{ $i == 0 ? "active" : "" }}">
                                            <img src="{{$service->galleries[$i]->getImageOptimizedFullName(1280,700) }}"
                                                 class="d-block w-100 border" alt="..."/>
                                        </div>
                                    @endfor
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </a>
                                <ol class="carousel-indicators">
                                    @for ($i = 0; $i < count($service->galleries); ++$i)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"
                                            class="{{$i == 0 ? "active": "" }}">
                                            <img src="{{$service->galleries[$i]->getImageOptimizedFullName(1280,700) }}"
                                                 class="d-block w-100 border">
                                        </li>
                                    @endfor
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-6 about-service">
                                    <h4 class="mb-3 fs-20">About This Service</h4>
                                    <div>{!! $service->content !!}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="service-packages-card card p-3">
                                    <ul class="nav nav-pills nav-fill mb-3 service-packages-pill rounded p-2" id="pills-tab" role="tablist">
                                        @foreach ($service->packages as $k => $package)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ $k == 0 ? 'active' : '' }}"
                                                        id="pills-{{ $package->id }}-tab"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#pills-{{ $package->id }}" type="button" role="tab"
                                                        aria-controls="pills-{{ $package->id }}"
                                                        aria-selected="true">{{ $package->name }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        @foreach ($service->packages as $k => $package)
                                            <div class="tab-pane fade {{ $k == 0 ? 'show active' : '' }}"
                                                id="pills-{{ $package->id }}" role="tabpanel"
                                                aria-labelledby="pills-{{ $package->id }}-tab">
                                                <h3>${{number_format($package->price / 100, 2)}}</h3>
                                                <h4>{{$package->name}}</h4>
                                                <p>{{$package->description}}</p>
                                                <p>{{$package->delivery_time}} Day Delivery</p>
                                                <p>{{$package->revisions}} Revisions</p>
                                                <a href="/services/checkout/{{$package->id}}" type="button"
                                                class="btn btn-primary w-100">Continue</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-6 about-seller card p-3">
                                    <h4 class="mb-4 fs-20">About this seller</h4>
                                    <div class="d-flex">
                                        <div class="">
                                            <img src="{{ $service->postauthor->uploads->getImageOptimizedFullName(100,100) }}"
                                                alt="avatar"
                                                class="rounded-circle img-fluid">
                                        </div>
                                        <div class="ml-15px">
                                            <a href="/u/{{ $service->postauthor->username }}" class="fs-18 fw-700 text-black">{{ $service->postauthor->full_name }}</a>
                                            <p class="mb-1 mt-1">{{ $service->seller->slogan == '' ? 'No Slogan' : $service->seller->slogan }}</p>
                                            @if ($rating->count > 0)
                                            <div class="mb-1">
                                                <span><i class="bi bi-star-fill fs-20 text-warning"></i> {{ $rating->rating ?: "0.0" }}</span>
                                                <span class="text-secondary">({{$rating->count}})</span>
                                            </div>
                                            @endif
                                            <div class="d-flex justify-content-start">
                                                <a class="text-primary" href="{{route('create_chat_room',['conversation_id'=>$service->seller->user->id])}}">Contact Me</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="car mt-3">
                                        <div class="card-bod">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <span class="text-muted mb-0">Member since</span>
                                                    <div class="fw-700">{{ $service->postauthor->created_at->format('M Y') }}</div>
                                                </div>
                                                <div class="col mb-3">
                                                    <span class="text-muted mb-0">Avg. response time</span>
                                                    <div class="fw-700">{{ !$service->postauthor->get_avg_response_time() == '-' ? '-' : (round($service->postauthor->get_avg_response_time() * 60) . (round($service->postauthor->get_avg_response_time() * 60) == 1 ? ' Minute' : ' Minutes')) }}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <span class="text-muted mb-0">Last delivery</span>
                                                    <div class="fw-700">{{ !$service->postauthor->last_delivery_time() ? 'None' : $service->postauthor->last_delivery_time()->diffForHumans() }}</div>
                                                </div>
                                            </div>

                                            <div class="border-top mt-3 pt-3">
                                                {{ $service->seller->about }}
                                            </div>
                                        </div>

                                        <hr>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
