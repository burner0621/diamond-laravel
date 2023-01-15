<div class="modal fade" id="CallFilesModal" tabindex="-1" aria-labelledby="uploadFilesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFilesModalLabel">Select File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab"
                            aria-controls="media" aria-selected="false">Media</a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab"
                            aria-controls="upload" aria-selected="false">Upload</a>
                    </li>
                </ul>
                <div class="tab-content" id="TabContent">

                    <div class="tab-pane fade show active" id="media" role="tabpanel" aria-labelledby="media-tab">
                        <!-- Folders -->
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4" id="modelmanagerAppend">
                            @foreach ($files as $file)
                                <div class="col mb-3 mb-lg-5"
                                    onclick="
                          @if ($is_product) return selectFileFromManagerMultiple({{ $file->id }}, '{{ url('uploads/all') }}/{{ $file->file_name }}')
                          @elseif($is_model)
                            return selectFileFromManagerModel({{ $file->id }});
                          @elseif($is_asset)
                            return selectFileFromManagerAsset({{ $file->id }});
                          @else
                            return selectFileFromManager({{ $file->id }}, '{{ url('uploads/all') }}/{{ $file->file_name }}') @endif
                          ">
                                    <!-- Card -->
                                    <div id="file-{{ $file->id }}"
                                        class="card card-sm card-hover-shadow card-header-borderless h-100 text-center 
                            @if (isset($selected) && in_array($file->id, $selected)) selected @endif
                            ">
                                        <div class="card-header card-header-content-between border-0">
                                            <span class="small">{{ $file->file_size }}kb</span>
                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                                @if ($is_product)
                                                    <button type="button"
                                                        @if (isset($selected) && !in_array($file->id, $selected)) style="display: none" @endif
                                                        class="btn btn-ghost-secondary bg-info text-white btn-icon btn-sm card-dropdown-btn check-this rounded-circle">
                                                        <i class="bi-check"></i>
                                                    </button>
                                                @endif
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="filesGridDropdown1" style="min-width: 13rem;">
                                                    <span class="dropdown-header">Settings</span>

                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-share dropdown-item-icon"></i> Share file
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-folder-plus dropdown-item-icon"></i> Move to
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-star dropdown-item-icon"></i> Add to stared
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-pencil dropdown-item-icon"></i> Rename
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-download dropdown-item-icon"></i> Download
                                                    </a>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-chat-left-dots dropdown-item-icon"></i> Report
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi-trash dropdown-item-icon"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Dropdown -->
                                        </div>

                                        <div class="card-body">
                                            @if ($file->type != 'image')
                                                <img src="https://jewelrycadfiles.com/assets/svg/brands/google-docs-icon.svg" alt="" style="height: 150px;">
                                            @else
                                                <img class="avatar-xxl"
                                                src="{{ url('uploads/all') }}/{{ $file->file_name }}"
                                                alt="Image Description">
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $file->file_original_name }}.{{ $file->extension }}</h5>
                                            <p class="small">Updated {{ $file->created_at->diffForHumans() }}</p>
                                        </div>

                                        <a class="stretched-link" href="javascript:;"></a>
                                    </div>
                                    <!-- End Card -->
                                </div>
                                <!-- End Col -->
                            @endforeach
                        </div>
                        <!-- End Folders -->
                    </div>
                    <div class="tab-pane fade show" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <!-- Dropzone -->
                        <div id="attachFilesNewProjectLabel" class="js-dropzone dz-dropzone dz-dropzone-card">
                            <div class="dz-message">
                                <img class="avatar avatar-xl avatar-4x3 mb-3"
                                    src="{{ asset('assets/img/icons') }}/oc-browse.svg" alt="Image Description"
                                    data-hs-theme-appearance="default">
                                <h5>Drag and drop your file here</h5>

                                <p class="mb-2">or</p>

                                <span class="btn btn-white btn-sm" id="browse"
                                    onclick='return uploadPrepareAjax(@if ($is_model) 1 @else 0 @endif ,@if ($is_product) 1 @else 0 @endif)'>Browse
                                    files</span>
                                <input type="file" id='prepare_images' name="file" multiple
                                    style="display: none">
                            </div>
                        </div>
                        <span class="btn btn-success btn-sm" id="browse"
                            onclick='return uploadAjax(@if ($is_model) 1 @else 0 @endif ,@if ($is_product) 1 @else 0 @endif , @if(isset($selected)) " " @else " " @endif)'>Upload</span>
                        <!-- End Dropzone -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
