@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Edit Product', 'navName' => 'Table List', 'activeButton' => 'catalogue'])

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
        $arrSelected = explode(',', $product->steps);
    @endphp

    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                       href="{{ route('backend.products.list') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>

                <h1 class="page-header-title">Edit Product</h1>

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

    <form action="{{ route('backend.products.edit_pending.update', $product) }}"
          id="frmUpdateProduct"
          method="post" enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('includes.validation-form')
        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card col-md-12">
                    <div class="card-body row">
                        @include('includes.validation-form')
                        <div class="mb-4">
                            <label for="name">Name</label>
                            <input type="text" value='{{ $product->name }}' name="name" id="name"
                                   class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="name">Slug</label>
                            <input type="text" value='{{ $product->slug }}' name="slug" id="slug"
                                   class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="desc">Description</label>
                            <textarea name="description" value='{{ $product->description }}' id="description" rows="3"
                                      class="form-control">{{ $product->description }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="card mb-3 mb-lg-5 mt-3">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title mb-0">Media</h4>

                        <!-- Gallery link -->
                        <label class="btn text-primary p-0" id="getFileManagerForProducts">
                            Select product gallery images
                            <input type="hidden" id="all_checks" value="{{ $product->product_images }}"
                                   name="product_images">
                        </label>
                        <!-- End Gallery link -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Gallery -->
                        <div id="fancyboxGallery" class="js-fancybox row justify-content-sm-center gx-3">
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

                                @include('backend.products.attributes.values.ajax',[
                                    'attributes' => $selected_values,
                                    'values_selected' => $values_selected
                                ])
                            </select>
                        </div>
                        <div class="mb-4 text-right">
                            <a class="btn btn-info btn-sm pull-right" id="generatevariants"
                               data-product-id="{{ $product->product_id }}">
                                Generate variants
                            </a>
                        </div>
                    </div>
                    <div class="card-body" id="variantsbody" style="overflow-x: scroll ">
                        @include('backend.products.ajax.values',[
                                'variants' => $variants,
                                'product_id' => $product->product_id,
                                'isDigital' => $product->is_digital
                                ])
                    </div>
                </div>

                <div class="card col-md-12">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Meta information</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body row">
                        @include('includes.validation-form')
                        <div class="mb-4">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" value='{{ $product->meta_title }}' name="meta_title" id="meta_title"
                                   class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" value='{{ $product->meta_description }}'
                                      id="meta_description" rows="3"
                                      class="form-control">{{ $product->meta_description }}</textarea>
                        </div>
                    </div>
                </div>

                @include('backend.products.materials.list')

                {{-- Product Lengths information --}}
                <div class="card col-md-12 mb-6">
                    <div class="card-header">
                        <h4 class="card-header-title">Product length</h4>
                        <select id="select_product_measurement" class="form-control select2" multiple style="">
                            @foreach($product_measurements as $product_measurement)
                                @php $is_searched = 0; @endphp
                                @foreach($product->measurements as $measurement)
                                    @if($product_measurement->id == $measurement->measurement_id)
                                        @php $is_searched = 1; @endphp
                                    @endif
                                @endforeach
                                <option data-product-measurement-full-name="{{ $product_measurement->full_name }}"
                                        value="{{ $product_measurement->id }}" {{ $is_searched ? 'selected' : '' }}>{{ $product_measurement->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card-body row">
                        <table class="table table-thead-bordered table-nowrap table-align-middle card-table table-responsive no-footer align-middle">
                            <thead>
                            <tr>
                                <th>Value</th>
                                <th>Measurement</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="product_measurement_table_body">
                            @foreach($product->measurements as $measurement)
                                <tr class="product-measurement-row"
                                    data-product-measurement-id="{{ $measurement->measurement_id }}">
                                    <td><input type="text" class="form-control" name="product_measurement_values[]"
                                               value="{{ $measurement->value }}" required></td>
                                    <td>
                                        {{ $measurement->product_measurement->full_name }}
                                        <input type="hidden" name="product_measurement_ids[]"
                                               value="{{ $measurement->measurement_id }}">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" type="button"
                                                onclick="delete_current_row(this)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card col-md-12 mb-6">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title mb-0">Steps information</h4>
                    </div>
                    <!-- End Header -->
                    <div class="card-body">
                        <div class="mb-2">
                            <label for="selStepType">Step Type</label>
                            <select name="step_type" id="selStepType" class="form-control">
                                <option value="0" selected>Select Type</option>
                                @foreach ($arrStepTypes as $id => $name)
                                    <option
                                            value="{{ $id + 1 }}"
                                            {{ $id + 1 == $product->step_type ? "selected" : "" }}
                                    >{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="divStepGroups" class="{{ $product->step_type == 1 ? "" : "d-none" }}">
                            <div class="mb-2">
                                <label for="selStepGroup">Step Group</label>
                                <select name="step_group" id="selStepGroup" class="form-control">
                                    @foreach ($arrStepGroups as $id => $name)
                                        <option
                                                value="{{ $id }}"
                                                {{ $id == $product->step_group ? "selected" : "" }}
                                        >{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="divSteps" class="{{ $product->step_type == 2 ? "" : "d-none" }}">
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
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-header-title mb-0">Status</h3>
                        <small class="text-muted"></small>
                    </div>
                    <div class="card-body">
                        {{ date('F d, Y, h:i:s A', strtotime($product->created_at)) }}
                        <br/>
                        <br/>
                        Seller: {{ $seller->first_name ?? ''}} {{  $seller->last_name ?? ''}}
                    </div>
                </div>
                <!-- End Card -->

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
                                <input type="checkbox" class="form-check-input" name="is_digital"
                                       @if($product->is_digital == 1) checked @endif id="availabilitySwitch1">
                            </span>
                        </label>
                        <label class="row form-switch mb-4" for="availabilitySwitch2">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Virtual</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_virtual" @if($product->is_virtual == 1) checked
                                       @endif class="form-check-input" id="availabilitySwitch2">
                            </span>
                        </label>
                        <label class="row form-switch" for="">
                            <span class="col-12 mb-2">
                                <span class="text-dark">Status</span>
                            </span>
                            <span class="col-12">
                            <select class="selectpicker w-100" name="status">
                                <option value="1" @if($product->status == 1) selected @endif>Published</option>
                                <option value="2" @if($product->status == 2) selected @endif>Pending Review</option>
                                <option value="3" @if($product->status == 3) selected @endif>Draft</option>
                                <option value="4" @if($product->status == 4) selected @endif>Denied</option>
                            </select>
                            </span>
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
                            <input type="text" value='{{ $product->price }}' name="price" id="price"
                                   class="form-control" placeholder="80.00...">
                        </div>
                        <div class="mb-4">
                            <label class="row form-switch mb-4" for="availabilitySwitch5">
                                <span class="col-8 col-sm-9 ms-0">
                                    <span class="text-dark">Track Quantity</span>
                                </span>
                                <span class="col-4 col-sm-3 text-end">
                                    <input type="checkbox" name="is_trackingquantity" value="1"
                                           @if($product->is_trackingquantity == 1) checked
                                           @endif class="form-check-input" id="availabilitySwitch5">
                                </span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label for="quantity">Quantity in Stock</label>
                            <input type="number" value='{{ $product->quantity }}' name="quantity" id="quantity"
                                   @if($product->is_trackingquantity == 0) disabled @endif
                                   class="form-control" min="0">
                        </div>
                        <label class="row form-switch mb-4" for="availabilitySwitch3">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Backorder</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_backorder" value="1"
                                       @if($product->is_backorder == 1) checked @endif class="form-check-input"
                                       id="availabilitySwitch3">
                            </span>
                        </label>
                        <label class="row form-switch mb-4" for="availabilitySwitch4">
                            <span class="col-8 col-sm-9 ms-0">
                                <span class="text-dark">Made to Order</span>
                            </span>
                            <span class="col-4 col-sm-3 text-end">
                                <input type="checkbox" name="is_madetoorder" value="1"
                                       @if($product->is_madetoorder == 1) checked @endif class="form-check-input"
                                       id="availabilitySwitch4">
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
                            <label for="category" class="mb-2">Category</label>
                            <div class="col-12">
                                <select class="selectpicker w-100" name="category" data-live-search="true">
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
                        </div>
                        <div class="mb-4">
                            <label for="name" class="mb-2">Tags</label>
                            <select name="tags[]" id="tags" value="" class="form-control select2"
                                    multiple="multiple" style="width: 100%;">
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
                <div class="card mb-3 mb-4" @if (!$product->is_digital) style="display: none;" @endif>
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
                            <option value="0">Not Taxable</option>
                            @foreach ($taxes as $tax)
                                <option @if ($product->tax_option_id == $tax->id) selected
                                        @endif value="{{ $tax->id }}">{{ $tax->name }} - {{ $tax->price / 100 }}
                                    ({{ $tax->type }})
                                </option>
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
                            <button type="button" class="btn btn-danger">Delete</button>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-light">Unpublish</button>
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

    <div id="fileManagerContainer"></div>

    <div id='ajaxCalls'>
    </div>
@endsection

@section('js_content')
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
            success: function (result) {
              $('#variantsbody').html(result)
            }
          })
        }
        // getVariants($('#availabilitySwitch1').prop('checked') * 1);
      })

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

    @stack('material_scripts')
@endsection
