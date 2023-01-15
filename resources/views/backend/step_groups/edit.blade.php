@extends('backend.layouts.app', ['activePage' => 'steps', 'title' => 'Edit Step Group', 'navName' => 'editstep_group', 'activeButton' => 'blog'])

@section('content')

<style>
#srtUnselected li, #srtSelected li {
    cursor: pointer;
    list-style-type: none;
}
</style>

@php
$arrSelected = explode(',', $step_group->steps);
@endphp

<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit step group</h1>
    </div>
    <!-- End Row -->
</div>

<form action="{{ route('backend.step_groups.update', $step_group->id) }}"
    id="frmUpdateStepGroup"
    method="post" enctype="multipart/form-data"
>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card col-md-12 mb-4">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Step Group information</h4>
                </div>
                <!-- End Header -->

                <div class="card-body row">
                    @include('includes.validation-form')
                    <div class="mb-2">
                        <label for="txtName" class="w-100 mb-2">Name:</label>
                        <input type="text" name="name" id="txtName" value="{{ $step_group->name }}" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="txaDescription" class="w-100 mb-2">Description:</label>
                        <textarea type="text" name="description" id="txaDescription" class="form-control"
                        >{{ $step_group->description }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label for="txaLink" class="w-100 mb-2">Steps:</label>
                        <div class="row">
                            <div class="col-6">
                                <ul id="srtUnselected" class="droptrue w-100 card px-1 py-2">
                                    @foreach ($arrSteps as $id => $name)
                                        @if (!in_array($id, $arrSelected))
                                            <li class="ui-state-default m-1 p-1 fs-16 rounded border-1"
                                                data-id="{{ $id }}"
                                            >{{ $name }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-6">
                                <ul id="srtSelected" class="droptrue w-100 card px-1 py-2">
                                    @foreach ($arrSelected as $id)
                                        @if (array_key_exists($id, $arrSteps))
                                            <li class="ui-state-default m-1 p-1 fs-16 rounded border-1"
                                                data-id="{{ $id }}"
                                            >{{ $arrSteps[$id] }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" name="steps" id='hidStepIds'/>
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
$(document).ready(function() {
    $("ul.droptrue").sortable({
      connectWith: "ul"
    });
 
    $( "#srtUnselected, #srtSelected" ).disableSelection();

    $('body').on('submit', '#frmUpdateStepGroup', function() {
        var step_ids = [];
        $('#srtSelected li').each(function() {
            step_ids.push($(this).data('id'));
        });

        $('#hidStepIds').val(step_ids.join(','));
    });
});

(function() {
    // INITIALIZATION OF QUILLJS EDITOR
    // =======================================================
    HSCore.components.HSQuill.init('.js-quill')
});
</script>
@endsection
