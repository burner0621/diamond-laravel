@extends('backend.layouts.app', ['activePage' => 'measurements', 'title' => 'Create Measurement', 'navName' => 'add_measurement', 'activeButton' => 'blog'])

@section('content')
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title">Edit measurement</h1>
        </div>
        <!-- End Row -->
    </div>
    <form action="{{ route('backend.measurements.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $measurement->id }}">
        <div class="row">
            <div class="col-md-8">
                <div class="card col-md-12 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Measurement information</h4>
                    </div>

                    <!-- End Header -->
                    <div class="card-body row">
                        <div class="mb-2">
                            <label for="name" class="mb-2">Name</label>
                            <input type="number" name="name" value="{{ $measurement->name }}" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="txtName" class="w-100 mb-2">Units</label>
                            <input type="text" name="units" value="{{ $measurement->units }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js_content')
    <script src="{{ asset('assets/vendor/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('assets/js/hs.quill.js') }}"></script>

    <script type="text/javascript">

      (function() {
        // INITIALIZATION OF QUILLJS EDITOR
        // =======================================================
        HSCore.components.HSQuill.init('.js-quill')
      });
    </script>

@endsection
