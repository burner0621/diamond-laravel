@extends('backend.layouts.app', ['activePage' => 'steps', 'title' => 'Edit Step', 'navName' => 'editstep', 'activeButton' => 'blog'])

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit step</h1>
    </div>
    <!-- End Row -->
</div>

<form action="{{ route('backend.steps.update', $step->id) }}"
    method="post" enctype="multipart/form-data"
>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card col-md-12 mb-4">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Step information</h4>
                </div>
                <!-- End Header -->

                <div class="card-body row">
                    @include('includes.validation-form')
                    <div class="mb-2">
                        <label for="txtName" class="w-100 mb-2">Name:</label>
                        <input type="text" name="name" id="txtName" value="{{ $step->name }}" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="txaDescription" class="w-100 mb-2">Description:</label>
                        <textarea type="text" name="description" id="txaDescription" class="form-control"
                        >{{ $step->description }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label for="txaLink" class="w-100 mb-2">Link:</label>
                        <textarea type="text" name="link" id="txaLink" class="form-control"
                        >{{ $step->link }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
        <!-- Card -->
        <div class="card card-sm bg-dark border-dark mx-2">
            <div class="card-body">
                <div class="row justify-content-center justify-content-sm-between">
                    <div class="col">
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                    <!-- End Col -->

                <div class="col-auto">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
            </div>
        </div>
        <!-- End Card -->
    </div>
</form>
@endsection

@section('js_content')
<script src="{{ asset('assets/vendor/quill/dist/quill.min.js') }}"></script>
<script src="{{ asset('assets/js/hs.quill.js') }}"></script>

<script>
(function() {
    // INITIALIZATION OF QUILLJS EDITOR
    // =======================================================
    HSCore.components.HSQuill.init('.js-quill')
});
</script>
@endsection
