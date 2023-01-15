@extends('backend.layouts.app', ['activePage' => 'filemanager', 'title' => 'File Manager', 'navName' => 'attributes', 'activeButton' => 'products'])

@section('content')
    <!-- Content -->
    <div class="container @@layoutBuilder.header.containerMode">
        <div class="page-header mb-4">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Content</a></li>
                            <li class="breadcrumb-item active" aria-current="page">File Manager</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title mb-0">File Manager</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body">
                        <form>
                            <input type="hidden" name="page" value="{{ request()->get('page') }}">
                            <div class="form-group">
                                <label for="filename">File Name</label>
                                <input type="text" class="form-control form-control-sm" id="filename"
                                    aria-describedby="emailHelp" placeholder="Filename" name="filename"
                                    value="{{ request()->get('filename') }}">
                                <small id="emailHelp" class="form-text text-muted">Enter any filename</small>
                            </div>
                            <div class="form-group">
                                <label for="filesize" class="form-label">File Size</label>
                                <input type="range" class="form-range" id="filesize" min="{{ $minFileSize }}"
                                    max="{{ $maxFileSize }}" name="filesize"
                                    value="{{ request()->get('filesize', $maxFileSize) }}">
                                <small id="emailHelp" class="form-text text-muted">{{ $minFileSize }} KB ~
                                    {{ $maxFileSize }} KB</small>
                            </div>
                            <label for="filesize" class="form-label">File Type</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="image" name="filetype_image"
                                    @if (request()->get('filetype_image')) checked @endif>
                                <label class="form-check-label" for="image">&nbsp;Image</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="asset" name="filetype_asset"
                                    @if (request()->get('filetype_asset')) checked @endif>
                                <label class="form-check-label" for="asset">&nbsp;Asset</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm d-block w-100"> Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-6">
                <div class="row">
                    @foreach ($files as $file)
                        @csrf
                        <div class="col-md-3">
                            <div class="card p-4" data-id="{{ $file->id }}">
                                <div class="dropdown">
                                    <a href="javascript:;" class="float-end" id="dropdown{{ $file->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
                                        <i class="bi bi-grid"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown{{ $file->id }}">
                                        <li>
                                            <a class="dropdown-item" href="javascript:;">
                                                <i class="bi bi-star"></i>
                                                Share
                                            </a>
                                            <div class="ms-2 me-2">
                                                <input type="text" class="form-control form-control-sm clipboard"
                                                    name="share" value="{{ $file->getFileFullPath() }}">
                                            </div>
                                        </li>
                                        @if (in_array($file->extension, ['glb', 'gltf', 'usdz']))
                                            <li>
                                                <a class="dropdown-item" href="javascript:;">
                                                    <i class="bi bi-badge-3d"></i>
                                                    3D Model
                                                </a>
                                                <div class="ms-2 me-2">
                                                    <input type="text" class="form-control form-control-sm clipboard"
                                                        name="model" value="[3d_viewer id={{ $file->id }}]">
                                                </div>
                                            </li>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('backend.file.destroy', $file->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="dropdown-item file-delete-btn">
                                                    <i class="bi bi-trash"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <span
                                    class="file-created-at">{{ date('F d, Y, h:i:s A', strtotime($file->created_at)) }}</span>
                                @if ($file->type != 'image')
                                    <img src="{{ asset('assets/img/file.svg') }}" alt="">
                                @else
                                    <img src="{{ $file->getImageOptimizedFullName() }}"
                                        class="card-img-top img-thumbnail" alt="{{ $file->file_name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $file->getOriginalFileFullName() }}</h5>
                                    <span class="file-size">{{ number_format($file->file_size/(1024*1024), 2, '.', ',') }} MB</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $files->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="toast" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-bs-autohide="false">
        <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Copied
        </div>
    </div>
    <!-- End Content -->
@endsection

@section('js_content')
    <script>
        $(function() {
            $('.clipboard').click(function() {
                navigator.clipboard.writeText($(this).val()).then(function() {
                    console.log('success');
                });
            });
            $('.file-delete-btn').click(function(e){
                if(confirm("Are you sure you want to delete this file")){
                }else{
                    e.preventDefault();
                }
            })            
        })
    </script>
@endsection
