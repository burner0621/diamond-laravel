@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Add Product', 'navName' => 'addproduct', 'activeButton' => 'catalogue'])

@section('content')
<style>
    #srtUnselected li, #srtSelected li {
        cursor: pointer;
        list-style-type: none;
    }
</style>

@php
$arrStepTypes = array(
    0   =>  'Step Group',
    1   =>  'Steps'
);
$arrSelected = explode(',', old('steps'));
@endphp

    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ route('backend.products.list') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Product</li>
                    </ol>
                </nav>

                <h1 class="page-header-title">Add Product</h1>

                <div class="mt-2">
                    <a class="text-body me-3" href="javascript:;">
                        <i class="bi-clipboard me-1"></i> Duplicate
                    </a>
                    <a class="text-body" href="#">
                        <i class="bi-eye me-1"></i> Preview
                    </a>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>

    <form action="{{ route('backend.products.store') }}"
        id="frmCreateProduct"
        method="post" enctype="multipart/form-data"
    >
        @csrf
        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Product information</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body">
                        @include('includes.validation-form')
                        <div class="mb-4">
                            <label for="productNameLabel" class="form-label">Name </label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="mb-4">
                            <label for="desc">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title mb-0">Media</h4>

                        <!-- Gallery link -->
                        <label class="btn text-primary p-0" id="getFileManagerForProducts">
                            Select product gallery images
                            <input type="hidden" id="all_checks" value="{{ old('product_images') }}" name="product_images">
                        </label>
                        <!-- Gallery link -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Gallery -->
                        <div id="fancyboxGallery" class="js-fancybox row justify-content-sm-center gx-3">

                        </div>
                        <!-- End Gallery -->

                        <!-- Dropzone -->

                        <!-- End Dropzone -->
                    </div>
                    <!-- Body -->
                </div>
                <div class="js-add-field card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-sm-between">
                        <h4 class="card-header-title mb-2 mb-sm-0">Variants</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name">Attributes:</label>
                            <select name="attributes[]" id="attributes" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                                @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}" data-tokens="{{ $attribute->name }}">
                                    {{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name">Attributes values:</label>
                            <select name="values[]" id="product_attribute_values" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                            </select>
                        </div>
                        <div class="mb-4 text-right">
                            <a class="btn btn-info btn-sm pull-right" id="generatevariants">
                                Generate variants
                            </a>
                        </div>
                    </div>
                    <div class="card-body" id="variantsbody" style="overflow-x: scroll ">
                    </div>
                </div>
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Meta information</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body">
                        @include('includes.validation-form')
                        <div class="mb-4">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                        </div>

                        <div class="mb-4">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card col-md-12 mb-6">
                    <!-- Header -->
                    <div class="card-header">
                       <h4 class="card-header-title mb-0">Steps information</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body">
                        @include('includes.validation-form')
                        <div class="mb-2">
                            <label for="selStepType">Step Type</label>
                            <select name="step_type" id="selStepType" class="form-control">
                                <option value="0" selected>Select Type</option>
                                @foreach ($arrStepTypes as $id => $name)
                                    <option
                                        value="{{ $id + 1 }}"
                                        {{ $id + 1 == old('step_type') ? "selected" : "" }}
                                    >{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="divStepGroups" class="{{ old('step_type') == 1 ? "" : "d-none" }}">
                            <div class="mb-2">
                                <label for="selStepGroup">Step Group</label>
                                <select name="step_group" id="selStepGroup" class="form-control">
                                    @foreach ($arrStepGroups as $id => $name)
                                        <option
                                            value="{{ $id }}"
                                            {{ $id == old('step_group') ? "selected" : "" }}
                                        >{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="divSteps" class="{{ old('step_type') == 2 ? "" : "d-none" }}">
                            <div class="row mb-2">
                                <label>Steps</label>
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
                        </div>
                        <input type="hidden" name="steps" id='hidStepIds'/>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Options</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <label class="row form-switch mb-4" for="availabilitySwitch1">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Digital</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" class="form-check-input" name="is_digital" id="availabilitySwitch1" {{ old('is_digital') ? 'checked' : '' }}>
                            </span>
                        </label>
                        <label class="row form-switch mb-4" for="availabilitySwitch2">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Virtual</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_virtual" class="form-check-input" id="availabilitySwitch2" {{ old('is_virtual') ? 'checked' : '' }}>
                            </span>
                        </label>
                        <label class="row form-check form-switch mb-4" for="">
                            <div class="col-12 mb-2">
                                <span class="text-dark" cla>Status</span>
                            </div>
                            <div class="col-12">
                                <select class="selectpicker w-100" name="status">
                                    <option value="1" selected>Published</option>
                                    <option value="2" >Pending Review</option>
                                    <option value="3" >Draft</option>
                                </select>
                            </div>
                        </label>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Pricing + Stock</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="priceNameLabel" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="0.00" value="{{ old('price', 0.00) }}">
                        </div>
                        <label class="row form-switch mb-4" for="availabilitySwitch5">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Track Quantity</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_trackingquantity" value="1" {{ old('is_trackingquantity') ? 'checked' : '' }} class="form-check-input" id="availabilitySwitch5">
                            </span>
                        </label>
                        <div class="mb-4">
                            <label for="qty">Quantity in Stock:</label>
                            <input type="number" name="quantity" id="quantity" {{ old('is_trackingquantity') ? '' : 'disabled' }}  class="form-control"  min="0" value="{{ old('quantity', 0) }}">
                        </div>
                        <label class="row form-switch mb-4" for="availabilitySwitch3">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Backorder</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_backorder" {{ old('is_backorder') ? 'checked' : '' }} value="1" class="form-check-input" id="availabilitySwitch3">
                            </span>
                        </label>
                        <label class="row form-switch mb-4" for="availabilitySwitch4">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Made to Order</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_madetoorder" {{ old('is_madetoorder') ? 'checked' : '' }} value="1" class="form-check-input" id="availabilitySwitch4">
                            </span>
                        </label>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Organization</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="category" class="mb-2">Category:</label>
                            <select class="selectpicker w-100" name="category" data-live-search="true">
                                <option disabled selected>Select category</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('category') == $categorie->id ? 'selected' : '' }} data-tokens="{{ $categorie->category_name }}">
                                        {{ $categorie->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="mb-2">Tags:</label>
                            <select name="tags[]" id="tags" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                                @foreach ($tags as $tag)
                                    <option value='{{ $tag->id }}'> {{ $tag->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">3D Model AR Preview</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <label class="btn text-primary mt-2 p-0" id="getFileManagerModel">Select 3d model</label>
                        <input type="hidden" id="fileManagerModelId" name="product_3dpreview" value="{{ old('product_3dpreview') }}">
                    </div>
                </div>
                <!-- End Card -->
                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Thumbnail</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="imagePreview img-thumbnail p-2">
                            <img id="fileManagerPreview" src="" style="width: 100%">
                        </div>
                        <label class="btn text-primary mt-2 p-0" id="getFileManager">Select thumbnail</label>
                        <input type="hidden" id="fileManagerId" name="product_thumbnail" value="{{ old('product_thumbnail') }}">
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-4" @if (!old('is_digital')) style="display: none;" @endif>
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Digital Asset File</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <label class="btn text-primary mt-2 p-0" id="getFileManagerAsset">Select asset</label>
                        <input type="hidden" id="digital_download_assets" name="digital_download_assets" value="{{ old('digital_download_assets') }}" >
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3 mb-4">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Tax</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <label for="tax_option_id">Tax</label>
                        <select name="tax_option_id" id="tax_option_id" class="form-control">
                            <option value="0" {{ old('tax_option_id') == 0 ? 'selected' : '' }}>Not Taxable</option>
                            @foreach ($taxes as $tax)
                                <option {{ old('tax_option_id') == $tax->id ? 'selected' : '' }} value="{{ $tax->id }}">{{ $tax->name }} - {{ $tax->price / 100 }} ({{ $tax->type }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- End Card -->

            </div>
        </div>

        <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
            <!-- Card -->
            <div class="card card-sm bg-dark border-dark mx-2">
                <div class="card-body">
                    <div class="row justify-content-center justify-content-sm-between">
                        <div class="col">
                            <button type="button" class="btn btn-ghost-danger">Cancel</button>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary">Create Product</button>
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

    <div id="fileManagerContainer"></div>

    <div id='ajaxCalls'>
    </div>

@endsection

@section('js_content')
    <script>
        var createChecks = [];
        
        $(document).ready(function() {
            $("ul.droptrue").sortable({
            connectWith: "ul"
            });
        
            $( "#srtUnselected, #srtSelected" ).disableSelection();

            $('body').on('submit', '#frmCreateProduct', function() {
                var step_ids = [];
                $('#srtSelected li').each(function() {
                    step_ids.push($(this).data('id'));
                });

                $('#hidStepIds').val(step_ids.join(','));
            });

            $('body').on('change', '#selStepType', function() {
                var step_type = $(this).val();
                // debugger;
                if (step_type == 0) {
                    $('#divStepGroups').addClass('d-none');
                    $('#divSteps').addClass('d-none');
                } else if (step_type == 1) {
                    $('#divStepGroups').removeClass('d-none');
                    $('#divSteps').addClass('d-none');
                } else {
                    $('#divStepGroups').addClass('d-none');
                    $('#divSteps').removeClass('d-none');
                }
            });
        });

        function removepreviewappended(id) {
            createChecks = jQuery.grep(createChecks, function(value) {
                return value != id;
            });
            $('#fileappend-' + id).remove();
            $('#all_checks').val(createChecks);
        }

        function selectFileFromManagerMultiple(id, preview) {
            if ($('#file-' + id).hasClass('selected')) {
                $('#file-' + id).removeClass('selected')
                $('#file-' + id).find('.check-this').fadeOut()
                removepreviewappended(id);
            } else {
                $('#file-' + id).addClass('selected')
                $('#file-' + id).find('.check-this').fadeIn()
                createChecks.push(id)
                $('#fancyboxGallery').prepend(productImageDiv(id, preview))
            }
            $('#all_checks').val(createChecks);
        }

        $('.select2').select2({
            tags: true,
            maximumSelectionLength: 10,
            tokenSeparators: [','],
            placeholder: "Select or type keywords",
        })

        // check the digital setting turn on
        $('#availabilitySwitch1').click(function () {
            if ($('#availabilitySwitch1').prop('checked')) {
                $('#digital_download_assets').val(0);
                $('#digital_download_assets').parent().parent().show();
            } else {
                $('#digital_download_assets').parent().parent().hide();
            }

            if ($('#variantsbody').html() != '') {
                var values_selected = $('#product_attribute_values').val()
                $.ajax({
                    type: 'POST',
                    url: "{{ route('backend.products.attributes.combinations') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "values": values_selected,
                        'isDigital': $('#availabilitySwitch1').prop('checked') * 1
                    },
                    success: function(result) {
                        $('#variantsbody').html(result)
                    }
                })
            }
        })

        $('#availabilitySwitch5').click(function () {
            var isTrackQuantity = $('#availabilitySwitch5').prop('checked');

            if (!isTrackQuantity) {
                $('#quantity').attr('disabled', 'true');
            } else {
                $('#quantity').removeAttr('disabled');
            }
        })

        $('#getFileManagerForProducts').click(function () {
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function (selectedId, filePath) {
                        $('#fancyboxGallery').empty();

                        createChecks = selectedId;
                        $('#all_checks').val(createChecks);

                        selectedId.map(function (id, i) {
                            $('#fancyboxGallery').prepend(productImageDiv(id, filePath[i]));
                        });
                    }

                    setSelectedItemsCB(getSelectedItem, createChecks);
                }
            })
        });

        var digital_download_assets = [];
        $('#getFileManagerModel').click(function () {
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function (selectedId, filePath) {

                        digital_download_assets = selectedId;
                        $('#fileManagerModelId').val(digital_download_assets);
                    }

                    setSelectedItemsCB(getSelectedItem, digital_download_assets, false);
                }
            })
        });

        $('#getFileManagerAsset').click(function () {
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function (selectedId, filePath) {

                        $('#digital_download_assets').val(selectedId);
                    }

                    setSelectedItemsCB(getSelectedItem, $('#digital_download_assets').val() == '' ? [] : [$('#digital_download_assets').val()], false);
                }
            })
        });

        $('#getFileManager').click(function () {
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function (selectedId, filePath) {

                        $('#fileManagerId').val(selectedId);
                    }

                    setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
                }
            })
        });

    </script>
@endsection
