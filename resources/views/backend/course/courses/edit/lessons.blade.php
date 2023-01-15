@php
use App\Models\CourseLesson;

$lessons = CourseLesson::where('course_id', $course->id)
    ->with('contents')
    ->get();
@endphp

<style>
.accordion-button::after {
    display: none;
}

.action {
    max-width: 75px !important;
}

.trumbowyg-box,
.trumbowyg-editor {
    min-height: 180px;
}
</style>

<div class="card col-md-12 mb-6">
    <!-- Header -->
    <div class="card-header">
        <h4 class="card-header-title mb-0">Lessons</h4>

        <button type="button" class="btn btn-sm btn-primary" id="btnAddLessonModal"
            data-bs-toggle="modal" data-bs-target="#modalAddLesson"
        >Add Lesson</button>
    </div>
    <!-- End Header -->

    <div class="card-body row">
        <div class="accordion" id="accLessons">
            @include('backend.course.courses.edit.lesson_items')
        </div>
    </div>
</div>

@include('backend.course.courses.edit.add_lesson')
@include('backend.course.courses.edit.add_lesson_content')

@include('backend.course.courses.edit.edit_lesson')
@include('backend.course.courses.edit.edit_lesson_content')

@push('lesson_scripts')
<script>

var course_id = {{ $course->id }};
var cur_lesson_id = 0;
var cur_lesson_content_id = 0;
var isButtonClicked = false;

$(document).ready(function() {
    $('body').on('click', '.accordion-button', function() {
        if (isButtonClicked) {
            isButtonClicked = false;
            return;
        }

        $('.btn-collapse', $(this).parents('.accordion-header')).trigger('click');
    });

    $('body').on('click', '.btn-delete-lesson', function() {
        isButtonClicked = true;
        var lesson_id = $(this).data('id');

        if (confirm('Do you want to delete this lesson really?')) {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('backend.courses.lessons.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "lesson_id": lesson_id,
                },
                dataType: "json",
                success: (result) => {
                    var lessons_html = result.lessons_html;
                    replaceLessonsHtml(lessons_html);
                },
                error: (resp) => {
                    var result = resp.responseJSON;
                    if (result.errors && result.message) {
                        alert(result.message);
                        return;
                    }
                }
            });
        }
    });

    $('body').on('click', '.btn-delete-lesson-content', function() {
        var lesson_content_id = $(this).data('id');

        if (confirm('Do you want to delete this lesson content really?')) {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('backend.courses.lessons.delete_content') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "lesson_content_id": lesson_content_id,
                },
                dataType: "json",
                success: (result) => {
                    var lessons_html = result.lessons_html;
                    replaceLessonsHtml(lessons_html);
                },
                error: (resp) => {
                    var result = resp.responseJSON;
                    if (result.errors && result.message) {
                        alert(result.message);
                        return;
                    }
                }
            });
        }
    });
});

var replaceLessonsHtml = function(lessons_html) {
    var arrDivId = [];
    $('.accordion-collapse.collapse').each(function() {
        if ($(this).hasClass('show')) {
            arrDivId.push($(this).attr('id'));
        }
    });

    $('#accLessons').html(lessons_html);

    for (let index = 0; index < arrDivId.length; index++) {
        const div_id = arrDivId[index];
        $('#' + div_id).addClass('show');
    }
}

</script>

@endpush
