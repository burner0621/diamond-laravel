<!-- Add Lesson Modal -->
<div class="modal fade" id="modalAddLesson" tabindex="-1" aria-labelledby="momdalAddLessonLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="momdalAddLessonLabel">Add Lesson</h5>
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
                <button type="button" class="btn btn-primary" id="btnAddLesson">Add</button>
            </div>
        </div>
    </div>
</div>

@push('lesson_scripts')
<script>
$(document).ready(function() {
    $('body').on('click', '#btnAddLessonModal', function() {
        $('#modalAddLesson #txtLessonName').val('');
    });

    $('body').on('click', '#btnAddLesson', function() {
        var lesson_name = $('#modalAddLesson #txtLessonName').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('backend.courses.lessons.store') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "course_id": course_id,
                "name": lesson_name
            },
            dataType: "json",
            success: (result) => {
                $('#modalAddLesson').modal('hide');
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
