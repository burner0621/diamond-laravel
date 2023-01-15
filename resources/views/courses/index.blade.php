<x-app-layout page-title="Courses">
    <section>
        <div class="container">
            <div class="section-page-title text-center col-xl-11 mx-auto pt-9 p-6">
                <h1 class="fw-800">Courses</h1>
                <p class="pb-4">All Courses</p>
            </div>
        </div>
    </section>

    <section class="bg-white pb-0">
        <div class="container">
            <div class="section-page-content col-xl-11 mx-auto">
                <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
                    @foreach ($arrCourses as $course)
                    @php
                        $course->setPriceToFloat()
                    @endphp
                    <div class="col mb-3">
                        <div class="blog-post-list-container">
                            <a href="{{ route('courses.show', $course->slug) }}" class="text-reset d-block">
                                @if($course->uploads->file_name == 'none.png')
                                    <img src="{{ asset('assets/img/placeholder.jpg') }}" alt="{{ $course->name }}" class="img-blog-cropped border lazyloaded rounded">
                                @else
                                    <img src="{{$course->uploads->getImageOptimizedFullName(960,540)}}" alt="{{ $course->name }}" class="img-blog-cropped border lazyloaded rounded">
                                @endif
                            </a>
                            <div class="p-2 pt-3">
                                <h2 class="fs-18 fw-600 mb-2">
                                    <a href="{{ route('courses.show', $course->slug) }}" class="text-reset article-list-title">
                                        {{ $course->name }}
                                    </a>
                                </h2>
                                <div class="mb-2 opacity-50 article-list-category">
                                    <span>$ {{ $course->price }} </span>
                                </div>
                            
                                <div class="mb-2 opacity-50 article-list-category">
                                    Published in: 
                                    <a href="{{ route('courses.category', $course->category->slug) }}">
                                        {{$course->category_name}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
    
