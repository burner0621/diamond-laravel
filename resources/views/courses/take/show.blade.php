<x-app-layout page-title="Courses">
    <section class="bg-white pt-9 pb-8">
        <div class="container">
            <div class="col-xl-10 mx-auto">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                @foreach ($course->lessons as $i => $lesson)
                                <div class="nav-item">
                                    <div class="fw-700 fs-20 pt-2 pb-2" href="#navbar" role="button" data-bs-toggle="collapse" data-bs-target="#navbar-{{$i}}" aria-expanded="true">
                                    <span class="nav-link-title">{{ $lesson->name }}</span>
                                    </div>
                                    <div id="navbar-{{$i}}" class="nav-collapse collapse show">
                                        @foreach ($lesson->contents as $j => $content)
                                        <div class="d-flex align-items-center icon-{{$i}}-{{$j}} mb-2">
                                            <a class="nav-link fs-16 fw-700 lesson @if ($content->history) text-success @endif" role="button" href="{{ route('courses.take', ['slug'=>Request::route('slug'), 'content' => $content->id]) }}">{{ $content->name }}</a>
                                            @if ($content->history)
                                            <i class="bi bi-check-lg text-success ml-5px"></i>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h1 class="fw-800 mb-4 title">{!! $course->name !!}</h1>
                        <p class="description">{!! $displayText !!}</p>
                        <a class='complete btn btn-light text-uppercase text-right mt-4 float-end' role="button" href="{{ route('courses.complete', ['slug'=>Request::route('slug'), 'content' => $nextId, 'id'=>$currentId]) }}">
                            complete @if ($nextId != $currentId) & continue @endif<i class='bi bi-arrow-right'></i>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>
</x-app-layout>
