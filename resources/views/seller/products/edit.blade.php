<x-app-layout>
    @section('css')

    <style>
        .pur {
            width: 100%;
            margin-bottom: 8px;
        }
        .navbar-brand{
            color: black !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend/app.css') }}" data-hs-appearance="default" as="style">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-9">
        <div class="container">
            <div class="header mb-3">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('seller.dashboard') }}">Seller Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">User Dashboard</a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header"><h3>Edit Product</h3></div>
                <div class="card-body">
                    @include('includes.validation-form')

                    <form action="{{ route('seller.product.update', $product) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <div class="card mb-3 mb-lg-5">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title mb-0">Product information</h4>
                                    </div>
                                    <!-- End Header -->
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="productNameLabel" class="form-label">Name </label>
                                            <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                                            <input type="text" name="name" id="name" class="form-control d-none" value="{{ $product->name }}">
                                        </div>

                                        <div class="mb-4">
                                            <label for="desc">Description</label>
                                            <textarea name="description" id="description" rows="3" class="form-control">{{ $product->description }}</textarea>
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
                                            <input type="hidden" id="all_checks" value="{{ $product->product_images }}" name="product_images">
                                        </label>
                                        <!-- Gallery link -->
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <!-- Gallery -->
                                        <div id="fancyboxGallery" class="js-fancybox row justify-content-sm-start gx-3">
                                        @foreach ($uploads as $upload)
                                            <div id="fileappend-{{$upload->id}}" class="col-6 col-sm-4 col-md-3 mb-3 mb-lg-5">
                                                <div class="card card-sm"><img class="card-img-top"
                                                                            src="{{ $upload->getFileFullPath() }}"
                                                                            alt="Image Description">
                                                    <div class="card-body">
                                                        <div class="row col-divider text-center">
                                                            <div class="col"><a class="text-body"
                                                                                href="./assets/img/1920x1080/img3.jpg"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top" title=""
                                                                                data-fslightbox="gallery"
                                                                                data-bs-original-title="View"><i class="bi-eye"></i></a>
                                                            </div>
                                                            <div class="col"><a onclick="removepreviewappended({{$upload->id}})"
                                                                                class="text-danger" href="javascript:;"><i
                                                                            class="bi-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
                                            @php
                                                $attributes_selected = explode(',', $product->product_attributes)
                                            @endphp
                                            <select name="attributes[]" id="attributes" value="" class="form-control select2"
                                                    multiple="multiple" style="width: 100%;">
                                                @foreach ($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}"
                                                            @if(in_array($attribute->id, $attributes_selected)) selected
                                                            @endif data-tokens="{{ $attribute->name }}">
                                                        {{ $attribute->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name">Attributes values:</label>
                                            @php
                                                $values_selected = explode(',', $product->product_attribute_values)
                                            @endphp
                                            <select name="values[]" id="product_attribute_values" value="" class="form-control select2"
                                                    multiple="multiple" style="width: 100%;">

                                                @include('seller.products.attributes.values.ajax',[
                                                    'attributes' => $selected_values,
                                                    'values_selected' => $values_selected
                                                ])
                                            </select>
                                        </div>
                                        <div class="mb-4 text-right">
                                            <a class="btn btn-info btn-sm pull-right" id="generatevariants">
                                                Generate variants
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body" id="variantsbody" style="overflow-x: scroll ">
                                        @include('seller.products.ajax.values',[
                                            'variants' => $variants,
                                            'product_id' => $product->id,
                                            'isDigital' => $product->is_digital
                                        ])
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">

                                <!-- Card -->
                                <!-- End Card -->

                                <!-- Card -->
                                <div class="card mb-3 mb-4">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title mb-0">Pricing</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="priceNameLabel" class="form-label">Price</label>
                                            <input type="text" value='{{ $product->price }}' name="price" id="price"
                                                class="form-control" placeholder="80.00...">
                                        </div>
                                        {{-- <label class="row form-switch mb-4" for="availabilitySwitch5">
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
                                        </label> --}}
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
                                            <input type="text" name="category" id="category" class="form-control d-none" value="{{ $product->category }}">
                                            <select class="selectpicker w-100" data-live-search="true" disabled>
                                                <option disabled>Select category</option>
                                                @foreach ($categories as $categorie)
                                                    <option value="{{ $categorie->id }}"
                                                            {{ $product->category == $categorie->id  ? 'selected' : ''  }}
                                                            data-tokens="{{ $categorie->category_name }}">
                                                        {{ $categorie->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name" class="mb-2">Tags:</label>
                                            <select name="tags[]" id="tags" value="" class="form-control select2"
                                                multiple="multiple" style="width: 100%;" disabled>
                                            @foreach ($tags as $tag)
                                                <option @if ($product->tags->contains('id_tag', $tag->id)) selected
                                                        @endif value='{{ $tag->id }}'>
                                                    {{ $tag->name }} </option>
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
                                        @if ($product->product_3dpreview != null)
                                            <div class="w-100">
                                                <span class="badge btn-success mb-2"> 3d model attached </span>
                                            </div>
                                            <div class="w-100">
                                                <span class="mb-2 d-block">{{$product->modelpreview->file_original_name . "." . $product->modelpreview->extension}}</span>
                                            </div>
                                        @else
                                            <div class="w-100">
                                                <span class="badge btn-danger mb-2"> No 3d model attached</span>
                                            </div>
                                        @endif

                                        <label class="btn text-primary p-0" id="getFileManagerModel">Select 3d model</label>
                                            <input class="d-none" id="fileManagerModelId" value="{{ $product->product_3dpreview }}" name="product_3dpreview">
                                            <div class="form-group mt-2">
                                                <span class="mb-2">Position</span>
                                                <input type="text" class="form-control" value="{{ $product->product_3dpreview_xyz }}" placeholder="Example 0.04139deg 127.6deg" name="product_3dpreview_xyz">
                                            </div>
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
                                            <img id="fileManagerPreview"
                                                src="{{ $product->uploads->getImageOptimizedFullName(400) }}"
                                                style="width: 100%">
                                        </div>
                                        <label class="btn text-primary mt-2 p-0" id="getFileManager">Select thumbnail</label>
                                        <input type="hidden" id="fileManagerId" value="{{$product->product_thumbnail}}"
                                            name="product_thumbnail">
                                    </div>
                                </div>
                                <!-- End Card -->

                                <!-- Card -->
                                <div class="card mb-3 mb-4" id="digitalAssetPanel">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title mb-0">Digital Asset File</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <p>
                                            @if ($product->digital_download_assets)
                                                <span class="badge btn-success"> Digital asset attached </span>
                                        <p>{{$product->digital->file_original_name . "." . $product->digital->extension}}</p>
                                        @else
                                            <span class="badge btn-danger"> No digital asset attached</span>
                                            @endif
                                            </p>
                                            <label class="btn text-primary mt-2 p-0" id="getFileManagerAsset">Select asset</label>
                                            <input type="hidden" id="digital_download_assets" name="digital_download_assets"
                                                value="{{ $product->digital_download_assets }}">
                                    </div>
                                </div>
                                <!-- End Card -->

                                <!-- Card -->
                                {{-- <div class="card mb-3 mb-4">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title mb-0">Tax</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <label for="tax_option_id">Tax</label>
                                        <select name="tax_option_id" id="tax_option_id" class="selectpicker form-control form-control-sm">
                                            <option value="0" {{ old('tax_option_id') == 0 ? 'selected' : '' }}>Not Taxable</option>
                                            @foreach ($taxes as $tax)
                                                <option {{ old('tax_option_id') == $tax->id ? 'selected' : '' }} value="{{ $tax->id }}">{{ $tax->name }} - {{ $tax->price / 100 }} ({{ $tax->type }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <!-- End Card -->

                            </div>
                        </div>
                        <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
                            <!-- Card -->
                            <div class="card card-sm bg-dark border-dark mx-2">
                                <div class="card-body">
                                    <div class="row justify-content-center justify-content-sm-between">
                                        <div class="col">
                                            <button type="button" class="btn btn-ghost-danger text-white">Cancel</button>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-auto">
                                            <div class="d-flex gap-3">
                                                <button type="submit" class="btn btn-primary">Update Product</button>
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
                </div>
            </div>
            <div id="fileManagerContainer"></div>

            <div id='ajaxCalls'>
            </div>
        </div>
    </div>
    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script>
        var createChecks = $('#all_checks').val() === '' ? [] : $('#all_checks').val().split(",");

        $(document).ready(function () {
            $("ul.droptrue").sortable({
            connectWith: "ul"
            });

            $("#srtUnselected, #srtSelected").disableSelection();

            $('body').on('submit', '#frmUpdateProduct', function () {
            var step_ids = [];
            $('#srtSelected li').each(function () {
                step_ids.push($(this).data('id'));
            });

            $('#hidStepIds').val(step_ids.join(','));
            });

            $('body').on('change', '#selStepType', function () {
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
            createChecks = jQuery.grep(createChecks, function (value) {
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

        $(document).ready(function () {
            $('.select2').select2({

            tags: true,
            maximumSelectionLength: 100,
            tokenSeparators: [','],
            placeholder: "Select or type keywords",
            })
        });

        // check the digital setting turn on

        $('#availabilitySwitch5').click(function () {
            var isTrackQuantity = $('#availabilitySwitch5').prop('checked');

            if (!isTrackQuantity) {
            // $('#quantity').val(0);
            $('#quantity').attr('disabled', 'true');
            } else {
            $('#quantity').removeAttr('disabled');
            }
        })

        $('#getFileManagerForProducts').click(function () {
            $.ajax({
            url: "{{ route('seller.file.show') }}",
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
            url: "{{ route('seller.file.show') }}",
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
            url: "{{ route('seller.file.show') }}",
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
            url: "{{ route('seller.file.show') }}",
            success: function (data) {
                if (!$.trim($('#fileManagerContainer').html()))
                $('#fileManagerContainer').html(data);

                $('#fileManagerModal').modal('show');

                const getSelectedItem = function (selectedId, filePath) {

                $('#fileManagerId').val(selectedId);
                $('#fileManagerPreview').attr('src', filePath);
                }

                setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
            }
            })
        });

        let delete_current_row = function (ele) {
            ele.closest('tr').remove()
        }

        $('#select_product_measurement').on('change', function (e) {
            let sel_val = $('#select_product_measurement').val()
            let new_html = ''
            for (let i = 0; i < $('tr.product-measurement-row').length; i++) {
            if(!sel_val.includes($('tr.product-measurement-row')[i].dataset.productMeasurementId)){
                $('tr.product-measurement-row')[i].remove()
            }
            }

            for (let i = 0; i < sel_val.length; i++) {
            if ($('tr[data-product-measurement-id="' + sel_val[i] + '"]').length == 0) {
                new_html += '<tr class="product-measurement-row" data-product-measurement-id="' + sel_val[i] + '">' +
                '<td><input type="text" class="form-control" name="product_measurement_values[]" required></td>' +
                '<td>' + $('#select_product_measurement option[value="' + sel_val[i] + '"]')[0].dataset.productMeasurementFullName +
                '<input type="hidden" name="product_measurement_ids[]" value="' + sel_val[i] + '"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="delete_current_row(this)">Delete</td>'
            }
            }

            $('#product_measurement_table_body')[0].insertAdjacentHTML('beforeend', new_html)
        })
        </script>
    @endsection
</x-app-layout>
