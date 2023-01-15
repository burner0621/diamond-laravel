@forelse ($lessons as $lesson)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <div class="hidden btn-collapse" data-bs-toggle="collapse"
                data-bs-target="#divLessonContent{{ $lesson->id }}"
            ></div>

            <div class="col-md-9 accordion-button" type="button">
                <div class="col-md-6">
                    {{ $lesson->name }}
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary btn-add-lesson-content-modal"
                        data-bs-toggle="modal" data-bs-target="#modalAddLessonContent" data-id="{{ $lesson->id }}"
                    >Add Lesson Content</button>

                    <button type="button" class="btn btn-sm btn-info btn-edit-lesson"
                        data-bs-toggle="modal" data-bs-target="#modalEditLesson"
                        data-id="{{ $lesson->id }}" data-name="{{ $lesson->name }}"
                    >Edit</button>

                    <button type="button" class="btn btn-sm btn-danger btn-delete-lesson"
                        data-id="{{ $lesson->id }}"
                    >Delete</button>
                </div>
            </div>
        </h2>
        <div id="divLessonContent{{ $lesson->id }}" class="accordion-collapse collapse">
            <div class="accordion-body">
                <table class="table table-thead-bordered table-nowrap table-align-middle card-table table-responsive no-footer">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Content</th>
                            <th class='text-center action'>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lesson->contents as $lesson_content)
                            <tr>
                                <td>{{ $lesson_content->name }}</td>
                                <td><?php echo $lesson_content->content; ?></td>
                                <td class='text-center action'>
                                    <button type="button" class="btn btn-sm btn-info me-1 btn-edit-content"
                                        data-bs-toggle="modal" data-bs-target="#modalEditLessonContent"
                                        data-id="{{ $lesson_content->id }}"
                                        data-lesson-id="{{ $lesson_content->lesson_id }}"
                                        data-name="{{ $lesson_content->name }}"
                                        data-content="{{ $lesson_content->content }}"
                                    >Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-lesson-content"
                                        data-id="{{ $lesson_content->id }}"
                                    >Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Lesson Conetnts</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="text-center">
        <h3>No Lessons</h3>
    </div>
@endforelse
