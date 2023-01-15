@extends('backend.layouts.app', ['activePage' => 'diamonds', 'title' => 'Create Diamond', 'navName' => 'addDiamond', 'activeButton' => 'blog'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Create Diamond</h1>
    </div>
    <!-- End Row -->
</div>
<form action="{{ route('backend.diamonds.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card col-md-12 mb-4">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Diamond information</h4>
                </div>

                <!-- End Header -->
                <input type="hidden" name="material_id" id="material_id" value="{{ $material_id }}" class="form-control">
                <div class="card-body row">
                    @include('includes.validation-form')
                    <div class="mb-2 col-4">
                        <label for="selectMaterialType" class="w-100 mb-2">Material Type:</label>
                        <select name="material_type_id" id="selectMaterialType" class="form-control">
                            @foreach ($material_types as $material_type)
                                <option value="{{$material_type->id}}">{{$material_type->type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="mb-2">
                        <label for="txtMMSize" class="w-100 mb-2">mm Size:</label>
                        <input type="text" name="mm_size" id="txtMMSize" value="{{ old('mm_size') }}" class="form-control">
                    </div>
                </div>
                <div class="card-body row">
                    <div class="mb-2">
                        <label for="txtXYSize" class="w-100 mb-2">XY Size:</label>
                        <input type="text" name="xy_size" id="txtXYSize" value="{{ old('xy_size') }}" class="form-control">
                    </div>
                </div>
                <div class="card-body row">
                    <div class="mb-2">
                        <label for="txtCaratWeight" class="w-100 mb-2">Carat Weight:</label>
                        <input type="text" name="carat_weight" id="txtCaratWeight" value="{{ old('carat_weight') }}" class="form-control">
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
                        <button type="submit" class="btn btn-primary">Create</button>
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

<script type="text/javascript">

(function() {
    // INITIALIZATION OF QUILLJS EDITOR
    // =======================================================
    HSCore.components.HSQuill.init('.js-quill')
});
</script>

@endsection
