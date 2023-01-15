<link rel="stylesheet" href="{{ asset('dropzone/css/bs-dropzone.css') }}">
<style>
    .modal-content{
        overflow: hidden;
    }
    .modal-body{
        overflow: auto;
    }    
    .check-option {
        right: 4px;
        top: 4px;
    }
</style>
<div class="modal fade" id="fileManagerModal" tabindex="-1" aria-labelledby="fileManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileManagerModalLabel">Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="file_explorer" data-bs-toggle="tab"
                            data-bs-target="#file_explorer_tab" type="button" role="tab"
                            aria-controls="file_explorer_tab" aria-selected="true">Explorer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="file_upload" data-bs-toggle="tab" data-bs-target="#file_upload_tab"
                            type="button" role="tab" aria-controls="file_upload_tab" aria-selected="false">File
                            Upload</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active py-4 px-4" id="file_explorer_tab" role="tabpanel"
                        aria-labelledby="file_explorer">
                        <input type="text" id="search_word" class="form-control m-auto w-50" placeholder="Search...">

                        <div class="row files-placeholder my-4">
                            @for ($i = 0; $i < 16; $i++)
                                <div class="card col-md-3 p-4">
                                    <div class="placeholder-glow">
                                        <span class="placeholder offset-md-2 placeholder-sm col-md-8"></span>
                                    </div>
                                    <div class="placeholder-glow">
                                        <span class="placeholder col-md-12" style="height: 132px;"></span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-center placeholder-glow">
                                            <span class="placeholder col-8"></span>
                                        </h5>
                                        <div class="placeholder-glow">
                                            <span
                                                class="placeholder offset-md-9 col-md-3 placeholder-sm file-size"></span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div id="files_container" class="py-4">
                            @include('backend.file-manager.modal.files-pagination', ['files' => $files])
                        </div>
                    </div>
                    <div class="tab-pane fade" id="file_upload_tab" role="tabpanel" aria-labelledby="file_upload">
                        <div class="p-4">
                            <form method="post" action="{{ route('backend.file.store') }}"
                                enctype="multipart/form-data" class="mb-0" name="file_upload_form">
                                <div class="form-group">
                                    <input type="file" name="file_upload_input" id="file_upload_input">
                                </div>
                                <div class="progress mb-3 d-none" id="file_upload_progressbar">
                                    <div class="progress-bar" style="width:10%">10%</div>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary upload-btn">
                                        <span class="spinner-border spinner-border-sm upload-btn-loading" role="status"
                                            aria-hidden="true"></span>
                                        <span class="upload-btn-loading-text">Loading</span>
                                        <span class="upload-btn-text">Upload</span>
                                    </button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('dropzone/js/bs-dropzone.js') }}"></script>
<script>
    var selected = [];
    var getSelectedItemsCB = null;
    var isRadio = false;

    $(function() {
        $('#file_upload_input').bs_dropzone({
            preview: true,
            boxClass: 'alert p-5 text-center font-weight-bold',
            noneColorClass: 'alert-info border-info',
            dragColorClass: 'alert-warning border-warning',
            doneColorClass: 'alert-success border-success',
            failColorClass: 'alert-danger border-danger'
        });

        $('.upload-btn-loading-text, .upload-btn-loading').hide();
        function uploadProgressHandler(event) {
            var percent = (event.loaded / event.total) * 100;
            var progress = Math.round(percent);
            $("#uploadProgressBar").css("width", progress + "%");
            $('#file_upload_progressbar .progress-bar').css("width", progress + "%");
            $('#file_upload_progressbar .progress-bar').html(progress + "%");
        }

        function loadHandler(event) {
            $('#file_upload_progressbar').addClass('d-none');
        }

        function errorHandler(event) {
        }

        function abortHandler(event) {
        }        
        document.file_upload_form.onsubmit = function() {
            if (document.getElementById('file_upload_input').files.length) {
                var formData = new FormData();
                formData.append('file', document.getElementById('file_upload_input').files[0]);
                formData.append('_token', "{{ csrf_token() }}");
                $('#file_upload_progressbar').removeClass('d-none');
                $('.upload-btn-loading-text, .upload-btn-loading').show();
                $('.upload-btn-text').hide();
                $('.upload-btn').attr('disable', true);

                $.ajax({
                    url: "{{ route('backend.file.store') }}",
                    type: 'post',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(data) {
                        $('.upload-btn-loading-text, .upload-btn-loading').hide();
                        $('.upload-btn-text').show();
                        $('.upload-btn').removeAttr('disable');

                        $('#file_explorer').click();
                        loadFiles();
                    },
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", uploadProgressHandler, false);
                        xhr.addEventListener("load", loadHandler, false);
                        xhr.addEventListener("error", errorHandler, false);
                        xhr.addEventListener("abort", abortHandler, false);

                        return xhr;
                    }                    
                });
            }

            return false;
        }

        var url = "{{ route('backend.file.show') . '?page=1' }}";

        $('.files-placeholder').hide();
        const loadFiles = function() {
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + `search=${$('#search_word').val()}`;

            $("#files_container").empty();
            $('.files-placeholder').show();
            $.get(finalURL, function(data) {
                $("#files_container").html(data);

                // select the items on other page
                selected.map(function(item) {
                    $(`#item${item}`).addClass('file-manager-item-checked');
                })

                $('.files-placeholder').hide();
            });
        }

        $(document).on("click", "span.page-link", function() {
            var attr = $(this).attr('data-href');

            if (typeof attr !== 'undefined' && attr !== false) {
                url = attr;
                loadFiles();
            }
        });

        $('#search_word').keyup(function() {
            loadFiles();
        });

        $('#files_container').on('click', '.file-manager-item', function() {
            if (isRadio) {
                $('#files_container').find('div').find('div').find('.file-manager-item').each(function(nIndex,
                item) {
                    if (id !== $(this).attr('data-id'))
                        $(this).removeClass('file-manager-item-checked');
                });

                selected = [];
            }

            $(this).toggleClass('file-manager-item-checked');
            var id = $(this).attr('data-id');

            if ($(this).hasClass('file-manager-item-checked')) {
                selected.push(id);
            } else {
                if (!isRadio)
                    selected.splice(selected.indexOf(id), 1);
            }

            getSelectedItems();
        });
    });

    const getSelectedItems = function() {
        if (getSelectedItemsCB) {
            var filePath = selected.map(function(item) {
                return $(`#item${item}`).attr('data-file-path');
            });

            getSelectedItemsCB(selected, filePath);
        }
    }

    const setSelectedItemsCB = function(cb, selectedId = [], isCheck = true) {
        getSelectedItemsCB = cb;
        selected = selectedId;
        isRadio = !isCheck;

        $('#files_container').find('div').find('div').find('.file-manager-item').each(function() {
            $(this).removeClass('file-manager-item-checked');
        })

        selected.map(function(item) {
            $(`#item${item}`).addClass('file-manager-item-checked');
        })
    }
</script>
