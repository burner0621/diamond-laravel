<x-app-layout page-title="Courses">

    <section class="bg-white pt-9 pb-8">
        <div class="container">
            <div class="col-xl-10 mx-auto">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="fw-800 mb-4">{{ $course->name }}</h1>
                        <div class="course-description"></div>
                    </div>
                    <div class="col-lg-4">
                        @if (Auth::check())
                            @if ($order && $order->status_payment == 2)
                            <div class="p-3 border mb-4">
                                <a type="button" class="btn btn-primary w-100" href="/courses/take/{{$course->slug}}">Take Course</a>
                            </div>
                            @else
                            <div class="p-3 border mb-4">
                                <h1 class="text-primary">${{ number_format($course->price/100, 2, ".", ",") }}</h1>
                                <a type="button" class="btn btn-primary w-100" href="/courses/checkout/{{$course->id}}">Buy</a>
                            </div>
                            @endif
                        @else
                            <div class="p-3 border mb-4">
                                <h1 class="text-primary">${{ number_format($course->price/100, 2, ".", ",") }}</h1>
                                <a type="button" class="btn btn-primary w-100" href="/courses/checkout/{{$course->id}}">Buy</a>
                            </div>
                        @endif

                        <div class="p-3 border">
                            <h1 class="text-black fs-20 fw-700 text-uppercase border-bottom pb-2 mb-4">Course Syllabus</h1>
                            <div class="course-content-list">
                                @foreach ($course->lessons as $lesson)
                                    <h3 class="fs-20 fw-700">{{ $lesson->name }}</h3>
                                    <ul>
                                        @foreach ($lesson->contents as $content)
                                            <li>{{ $content->name }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

<script>
$(function() {

    var course = @php echo json_encode($course) @endphp;

    $(function() {
        $('.course-description').html(course.description)
    })
});
</script>
