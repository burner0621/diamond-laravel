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
                <div class="card-header"><h3>Add Product</h3></div>
                <div class="card-body">
                    @include('includes.validation-form')
                    
                    <form action="{{ route('seller.product.store') }}" method="post" enctype="multipart/form-data">
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
                                        <div id="fancyboxGallery" class="js-fancybox row justify-content-sm-start gx-3">
                
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
                                            <select name="attributes[]" id="attributes" value="" class="form-control form-control-sm select2"
                                                multiple="multiple" style="width: 100%;">
                                                @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}" data-tokens="{{ $attribute->name }}">
                                                    {{ $attribute->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name">Attributes values:</label>
                                            <select name="values[]" id="product_attribute_values" value="" class="form-control form-control-sm select2"
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
                            </div>
                
                            <div class="col-lg-4">
                
                                <!-- Card -->
                                {{-- <div class="card mb-3 mb-4">
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
                                    </div>
                                </div> --}}
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
                                            <input type="text" name="price" id="price" class="form-control" placeholder="0.00" value="{{ old('price', 0.00) }}">
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
                                            <select class="selectpicker w-100 form-control form-control-sm" name="category" data-live-search="true">
                                                <option disabled selected>Select category</option>
                                                @foreach ($categories as $categorie)
                                                    <option value="{{ $categorie->id }}" {{ old('category') == $categorie->id ? 'selected' : '' }} data-tokens="{{ $categorie->category_name }}">
                                                        {{ $categorie->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name" class="mb-2">Tags:</label>
                                            <select name="tags[]" id="tags" value="" class="form-control form-control-sm select2"
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
                                        <p class="text-danger">Please export your 3D Model file fully assembled then convert it to a .glb file and upload it here. All layers should be assembled, all materials should be visible. <a href="#">learn more.</a></p>
                                        <div class="imagePreview img-thumbnail p-2">
                                            <img id="3dFilePreview" src="" style="width: 100%">
                                        </div>                                        
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
                                    <p class="text-danger">Please make sure your thumbnail matches the thumbnail color scheme and format. Learn more on how to achieve the needed look. <a href="#">learn more.</a></p>
                                        <div class="imagePreview img-thumbnail p-2">
                                            <img id="thumbnailPreview" src="" style="width: 100%">
                                        </div>
                                        <label class="btn text-primary mt-2 p-0" id="getFileManager">Select thumbnail</label>
                                        <input type="hidden" id="fileManagerId" name="product_thumbnail" value="{{ old('product_thumbnail') }}">
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
                                        <div class="imagePreview img-thumbnail p-2">
                                            <img id="digitalAssetPreview"
                                                src=""
                                                style="width: 100%">
                                        </div>                                        
                                        <label class="btn text-primary mt-2 p-0" id="getFileManagerAsset">Select asset</label>
                                        <input type="hidden" id="digital_download_assets" name="digital_download_assets" value="{{ old('digital_download_assets') }}" >
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
            $(function(){
                $('.select2').select2({
                    tags: true,
                    maximumSelectionLength: 10,
                    tokenSeparators: [','],
                    placeholder: "Select or type keywords",
                });
                $('#attributes').on('change', function() {
                    var attributes = $(this).val()
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('backend.products.attributes.ajaxcall') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "attributes": attributes
                        },
                        success: (data) => {
                            $('#product_attribute_values').html(data);
                        }
                    })
                })

                var getVariants = function(isDigital, productId) {
                    var values_selected = $('#product_attribute_values').val();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('backend.products.attributes.combinations') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "values": values_selected,
                            'isDigital': isDigital,
                            product_id: productId
                        },
                        success: function(result) {
                            $('#variantsbody').html(result)
                        }
                    })
                }

                $('#generatevariants').on('click', function() {
                    $('#digitalAssetPanel').addClass('d-none');
                    getVariants($('#availabilitySwitch1').prop('checked') * 1, $(this).attr('data-product-id'));
                })                
                var createChecks = [];
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
                function productImageDiv(id, preview) {
                    var div = '<div id="fileappend-' + id + '" class="col-6 col-sm-4 col-md-3 mb-3 mb-lg-5">' +
                        '<div class="card card-sm">' +
                        '<img class="card-img-top" src="' + preview + '" alt="Image Description">' +

                        '<div class="card-body">' +
                        '<div class="row col-divider text-center">' +
                        '<div class="col">' +
                        '<a class="text-body" href="./assets/img/1920x1080/img3.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-fslightbox="gallery" data-bs-original-title="View">' +
                        '<i class="bi-eye"></i>' +
                        '</a>' +
                        '</div>' +


                        '<div class="col">' +
                        '<a onclick="removepreviewappended(' + id +
                        ')" class="text-danger" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">' +
                        '<i class="bi-trash"></i>' +
                        '</a>' +
                        '</div>' +
                        '</div>' +

                        '</div>' +
                        '</div>' +
                        '</div>';
                    return div;
                }                           
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
                var digital_download_assets = [];
                $('#getFileManagerModel').click(function () {
                    $.ajax({
                        url: "{{ route('backend.file.show') }}",
                        success: function (data) {
                            if (!$.trim($('#fileManagerContainer').html()))
                                $('#fileManagerContainer').html(data);

                            $('#fileManagerModal').modal('show');

                            const getSelectedItem = function (selectedId, filePath) {
                                $('#3dFilePreview').removeClass('d-none');
                                $('#3dFilePreview').attr('src', filePath);
                                digital_download_assets = selectedId;
                                $('#fileManagerModelId').val(digital_download_assets);
                            }

                            setSelectedItemsCB(getSelectedItem, digital_download_assets, false);
                        }
                    })
                });    
                var digital_assets = [];
                $('#getFileManagerAsset').click(function () {
                    $.ajax({
                        url: "{{ route('backend.file.show') }}",
                        success: function (data) {
                            if (!$.trim($('#fileManagerContainer').html()))
                                $('#fileManagerContainer').html(data);

                            $('#fileManagerModal').modal('show');

                            const getSelectedItem = function (selectedId, filePath) {
                                $('#digitalAssetPreview').removeClass('d-none');
                                $('#digitalAssetPreview').attr('src', filePath);                                
                                digital_assets = selectedId;
                                $('#digital_download_assets').val(digital_assets);
                            }

                            setSelectedItemsCB(getSelectedItem, digital_assets, false);
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
                                $('#thumbnailPreview').removeClass('d-none');
                                $('#thumbnailPreview').attr('src', filePath);
                                $('#fileManagerId').val(selectedId);
                            }

                            setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
                        }
                    })
                });                            
            })
        </script>
    @endsection
</x-app-layout>
