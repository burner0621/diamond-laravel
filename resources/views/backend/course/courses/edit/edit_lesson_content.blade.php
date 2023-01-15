<!-- Edit Lesson Modal -->
<div class="modal fade" id="modalEditLessonContent" tabindex="-1" aria-labelledby="momdalEditLessonContentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="momdalEditLessonContentLabel">Edit Lesson Content</h5>
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
                    <textarea class="form-control modal-editor" id="txaLessonContentContent"></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnUpdateLessonContent">Update</button>
            </div>
        </div>
    </div>
</div>

@push('lesson_scripts')
<script>
    createInlineEditor(".modal-editor").then((editor) => {
        document.editor = editor
    })
    function createInlineEditor (selector) {
        return new Promise(((resolve, reject) => {
            ClassicEditor.create(document.querySelector(selector), {
                toolbar: [
                    'heading',
                    'CKFinder',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'code',
                    'codeBlock',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo'
                ],
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },

                ckfinder: {
                    openerMethod: 'popup',
                    uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                    options: {
                        resourceType: 'Images',
                    }
                }
            }).then(data => resolve(data)).catch(error => reject(error))
                .catch( function( error ) {
                    console.error( error );
                } );

        }))
    }
$(document).ready(function() {

    $('body').on('click', '.btn-edit-content', function() {
        cur_lesson_id = $(this).data('lesson-id');
        cur_lesson_content_id = $(this).data('id');
        var lesson_content_name = $(this).data('name');
        var lesson_content_content = $(this).data('content');

        $('#modalEditLessonContent #txtLessonContentName').val(lesson_content_name);
        document.editor.setData(lesson_content_content);
    });

    $('body').on('click', '#btnUpdateLessonContent', function() {
        var lesson_content_name = $('#modalEditLessonContent #txtLessonContentName').val();
        var lesson_content_content = document.editor.getData();

        $.ajax({
            type: 'POST',
            url: "{{ route('backend.courses.lessons.update_content') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "PUT",
                "lesson_id": cur_lesson_id,
                "content_id": cur_lesson_content_id,
                "name": lesson_content_name,
                "content": lesson_content_content,
            },
            dataType: "json",
            success: (result) => {
                $('#modalEditLessonContent').modal('hide');
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
