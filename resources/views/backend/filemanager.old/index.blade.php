@extends('backend.layouts.app', ['activePage' => 'filemanager', 'title' => 'File Manager', 'navName' => 'attributes', 'activeButton' => 'products'])

@section('content')
    <!-- Content -->
    <div class="content @@layoutBuilder.header.containerMode">
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
                            <div class="form-group">
                                <label for="filename">File Name</label>
                                <input type="text" class="form-control form-control-sm" id="filename"
                                    aria-describedby="emailHelp" placeholder="Filename" name="filename"
                                    value="{{ old('filename') }}">
                                <small id="emailHelp" class="form-text text-muted">Enter any filename</small>
                            </div>
                            <div class="form-group">
                                <label for="filesize" class="form-label">File Size</label>
                                <input type="range" class="form-range" id="filesize" min="0" name="filesize"
                                    value="{{ old('filesize') }}">
                                <small id="emailHelp" class="form-text text-muted">0KB ~ 5MB</small>
                            </div>
                            <label for="filesize" class="form-label">File Type</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="image" name="filetype-image">
                                <label class="form-check-label" for="image"
                                    @if (old('filetype-image')) checked @endif>&nbsp;Image</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="asset" name="filetype-asset">
                                <label class="form-check-label" for="asset"
                                    @if (old('filetype-asset')) checked @endif>&nbsp;Asset</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm d-block w-100"> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-6">
                <div class="row">
                    @foreach ($files as $file)
                        <div class="col-md-4">
                            <div class="card p-4" data-id="{{ $file->id }}">
                                <span
                                    class="file-created-at">{{ date('F d, Y, h:i:s A', strtotime($file->created_at)) }}</span>
                                @if ($file->type != 'image')
                                    <img src="{{ asset('assets/svg/brands/google-docs-icon.svg') }}" alt="">
                                @else
                                    <img src="{{ $file->getImageOptimizedFullName() }}" class="card-img-top img-thumbnail"
                                        alt="{{ $file->file_name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $file->getOriginalFileFullName() }}</h5>
                                    <span class="file-size">{{ $file->file_size }} KB</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
@endsection

@section('js_content')
    <script></script>
@endsection
