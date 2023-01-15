<!-- Edit Lesson Modal -->
<div class="modal fade" id="modalEditLesson" tabindex="-1" aria-labelledby="momdalEditLessonLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="momdalEditLessonLabel">Edit Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="mb-3">
                    <label for="txtLessonName" class="col-form-label">Lesson Name:</label>
                    <input type="text" class="form-control" id="txtLessonName">
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnUpdateLesson">Update</button>
            </div>
        </div>
    </div>
</div>

@push('lesson_scripts')
<script>

$(document).ready(function() {
    $('body').on('click', '.btn-edit-lesson', function() {
        isButtonClicked = true;
        cur_lesson_id = $(this).data('id');
        var lesson_name = $(this).data('name');
        $('#modalEditLesson #txtLessonName').val(lesson_name);
    });

    $('body').on('click', '#btnUpdateLesson', function() {
        var lesson_name = $('#modalEditLesson #txtLessonName').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('backend.courses.lessons.update') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "PUT",
                "course_id": course_id,
                "lesson_id": cur_lesson_id,
                "name": lesson_name
            },
            dataType: "json",
            success: (result) => {
                $('#modalEditLesson').modal('hide');
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
    });
});
</script>
@endpush
