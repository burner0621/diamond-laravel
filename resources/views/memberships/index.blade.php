<x-app-layout page-title="Memberships">
    <section class="hero-home pt-8 pb-9">
        <div class="container">
            <div class="col-xl-11 mx-auto pb-3">
                <h1 class="fw-800 text-left">Memberships</h1>
            </div>

            <div class="col-xl-11 mx-auto">
                <div class="row">
                    @foreach ($arrMemberships as $membership)
                        @php
                            $membership->setPricesToFloat();
                        @endphp
                        <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                            <div class="blog-post-list-container">
                                @if($membership->uploads->file_name == 'none.png')
                                    <img src="{{ asset('assets/img/placeholder.jpg') }}" alt="{{ $membership->name }}" class="img-blog-cropped border lazyloaded">
                                @else
                                    <img src="{{$membership->uploads->getImageOptimizedFullName(400)}}" alt="{{ $membership->name }}" class="img-blog-cropped border lazyloaded">
                                @endif
                                
                                <div class="p-2 pt-3">
                                    <h2 class="fs-18 fw-600 mb-2">
                                        {{ $membership->name }}
                                    </h2>

                                    <div class="mb-2 opacity-80 article-list-category">
                                        <span>$ {{ $membership->price }} </span>
                                    </div>

                                    @if ($membership->price_monthly > 0)
                                        <div class="mb-2 opacity-80 article-list-category">
                                            <span>$ {{ $membership->price_monthly }} / Monthly</span>
                                        </div>
                                    @endif

                                    @if ($membership->included_downloads > 0)
                                        <div class="mb-2 opacity-80 article-list-category">
                                            <span>{{ $membership->included_downloads }} Downloads </span>
                                        </div>
                                    @endif

                                    @if ($membership->included_downloads_monthly > 0)
                                        <div class="mb-2 opacity-80 article-list-category">
                                            <span>{{ $membership->included_downloads_monthly }} Downloads / Monthly </span>
                                        </div>
                                    @endif

                                    @if ($membership->unlimited_downloads > 0)
                                        <div class="mb-2 opacity-80 article-list-category">
                                            <span>Unlimited CAD </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
