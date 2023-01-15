<!-- Add Lesson Modal -->
<div class="modal fade" id="modalAddLessonContent" tabindex="-1" aria-labelledby="momdalAddLessonContentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="momdalAddLessonContentLabel">Add Lesson Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="mb-3">
                    <label for="txtLessonContentName" class="col-form-label">Name:</label>
                    <input type="text" class="form-control" id="txtLessonContentName">
                </div>

                <div class="mb-3">
                    <label for="txaLessonContentContent" class="col-form-label">Content:</label>
                    <textarea class="form-control" id="txaLessonContentContent"></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnAddLessonContent">Add</button>
            </div>
        </div>
    </div>
</div>


@push('lesson_scripts')
<script>
$(document).ready(function() {
    var wyg = $('#modalAddLessonContent #txaLessonContentContent').trumbowyg();

    $('body').on('click', '.btn-add-lesson-content-modal', function() {
        isButtonClicked = true;
        $('#modalAddLessonContent #txtLessonContentName').val('');
        wyg.trumbowyg('html', '');
        cur_lesson_id = $(this).data('id');
    });

    $('body').on('click', '#btnAddLessonContent', function() {
        var lesson_content_name = $('#modalAddLessonContent #txtLessonContentName').val();
        var lesson_content_content = $('#modalAddLessonContent #txaLessonContentContent').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('backend.courses.lessons.store_content') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "lesson_id": cur_lesson_id,
                "name": lesson_content_name,
                "content": lesson_content_content
            },
            dataType: "json",
            success: (result) => {
                $('#modalAddLessonContent').modal('hide');
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
