<table id="datatable"
    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer"
    role="grid" aria-describedby="datatable_info">
    <thead class="thead-light">
        <tr role="row">
            <th class="table-column-ps-0 sorting" valign="middle" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                aria-label="Color: activate to sort column ascending">Value</th>
            <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                aria-label="Price: activate to sort column ascending">Price</th>
            <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                aria-label="Price: activate to sort column ascending">Sku</th>
            <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                aria-label="Quantity: activate to sort column ascending">Quantity</th>
            <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                aria-label="Quantity: activate to sort column ascending">Photo</th>
            @if ($isDigital)
                <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                    colspan="1" aria-label="Quantity: activate to sort column ascending">Digital</th>
            @endif
            <th class="table-column-ps-0 sorting_disabled" rowspan="1" colspan="1" aria-label=""></th>
        </tr>
    </thead>
    <tbody id="addVariantsContainer">
        @forelse($variants as $k => $variant)
            @php
                $current_name = '';
                $attributes_ids = '';
                $variants_ids = '';
            @endphp
            @if (!isset($variant->id))
                @php
                    foreach ((array) $variant as $key => $parameters) {
                        $params = explode('-', $parameters);
                        $sep = $key == 0 ? '' : ' - ';
                        $sep2 = $key == 0 ? '' : ',';
                        $current_name .= $sep . $params[2];
                        $variants_ids .= $sep2 . $params[1];
                        $attributes_ids .= $sep2 . $params[0];
                    }
                @endphp
            @else
                @php
                    $variants_ids = $variant->variant_attribute_value;
                @endphp
            @endif

            <tr role="row" class="odd" id="variantproduct-{{ $k }}">
                <input type="hidden" name="variant[{{ $k }}][id]"
                    @if (isset($variant->id)) value="{{ $variant->id }}" @else value="0" @endif
                    id="variant_id_{{ str_replace(',', '_', $variants_ids) }}">
                <input type="hidden" name="variant[{{ $k }}][variant_attribute_value]"
                    @if (isset($variant->variant_attribute_value)) value="{{ $variant->variant_attribute_value }}" @else value="{{ $variants_ids }}" @endif>

                <th class="table-column-ps-0">
                    @if (isset($variant->variant_name))
                        {{ $variant->variant_name }}
                    @else
                        {{ $current_name }}
                    @endif
                    <input type="hidden" name="variant[{{ $k }}][variant_name]"
                        @if (isset($variant->variant_name)) value="{{ $variant->variant_name }}"
                    @else
                        value="{{ $current_name }}" @endif>
                </th>
                <th class="table-column-ps-0">
                    <div class="input-group input-group-merge" style="min-width: 7rem;">
                        <div class="input-group-prepend input-group-text">USD</div>
                        <input type="text" class="form-control"
                            id="variant_price_{{ str_replace(',', '_', $variants_ids) }}"
                            name="variant[{{ $k }}][variant_price]"
                            @if (isset($variant->variant_price)) value='{{ $variant->variant_price }}' @else value='0' @endif>
                    </div>
                </th>
                <th class="table-column-ps-0">
                    <div class="input-group input-group-merge" style="width: 11rem;">
                        <div class="input-group-prepend input-group-text">SKU</div>
                        <input type="text" class="form-control"
                            id="variant_sku_{{ str_replace(',', '_', $variants_ids) }}"
                            name="variant[{{ $k }}][variant_sku]"
                            @if (isset($variant->variant_sku)) value='{{ $variant->variant_sku }}' @endif>
                    </div>
                </th>

                <th class="table-column-ps-0">
                    <!-- Quantity -->
                    <div class="quantity-counter">
                        <div class="js-quantity-counter-input row align-items-center">
                            <div class="col">
                                <input class="js-result form-control form-control-quantity-counter" type="text"
                                    name="variant[{{ $k }}][variant_quantity]"
                                    id="variant_quantity_{{ str_replace(',', '_', $variants_ids) }}"
                                    @if (isset($variant->variant_quantity)) value='{{ $variant->variant_quantity }}' @else value="1" @endif>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <a class="js-minus btn btn-white btn-xs btn-icon rounded-circle" href="javascript:;">
                                    <svg width="8" height="2" viewBox="0 0 8 2" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0 1C0 0.723858 0.223858 0.5 0.5 0.5H7.5C7.77614 0.5 8 0.723858 8 1C8 1.27614 7.77614 1.5 7.5 1.5H0.5C0.223858 1.5 0 1.27614 0 1Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </a>
                                <a class="js-plus btn btn-white btn-xs btn-icon rounded-circle" href="javascript:;">
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 0C4.27614 0 4.5 0.223858 4.5 0.5V3.5H7.5C7.77614 3.5 8 3.72386 8 4C8 4.27614 7.77614 4.5 7.5 4.5H4.5V7.5C4.5 7.77614 4.27614 8 4 8C3.72386 8 3.5 7.77614 3.5 7.5V4.5H0.5C0.223858 4.5 0 4.27614 0 4C0 3.72386 0.223858 3.5 0.5 3.5H3.5V0.5C3.5 0.223858 3.72386 0 4 0Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </a>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Quantity -->
                </th>
                <th class="table-column-ps-0">
                    <a href='javascript:;' onclick="fileSelect({{ $k }})"> select </a>
                    <input type="hidden" name="variant[{{ $k }}][variant_thumbnail]"
                        class="variant_thumbnail_{{ str_replace(',', '_', $variants_ids) }}"
                        id="variant-{{ $k }}-thumbnail"
                        @if (isset($variant->variant_thumbnail)) value='{{ $variant->variant_thumbnail }}' @endif>
                    <div id="selected_{{ $k }}_image" class="selected-image">
                        {{-- @php
                            if (isset($variant->variant_thumbnail)) {
                                echo "<img src='" . asset('/uploads/all') . '/' . $variant->uploads->file_name . "' style='width:150px;height:100px'/>";
                            }
                        @endphp --}}
                    </div>
                </th>
                @if ($isDigital)
                    <th class="table-column-ps-0" style="text-align: center;">
                        <a href='javascript:;' onclick="assetSelect({{ $k }})"> upload </a><br /><br />
                        <input type="hidden" name="variant[{{ $k }}][digital_download_assets]"
                            class="variant_asset_{{ str_replace(',', '_', $variants_ids) }}"
                            id="variant-{{ $k }}-assets"
                            @if (isset($variant->digital_download_assets)) value='{{ $variant->digital_download_assets }}' @endif>
                        <div id="selected_{{ $k }}_asset" class="selected-asset">
                            @php
                                if (isset($variant->digital_download_assets)) {
                                    echo '<img src="https://jewelrycadfiles.com/assets/img/file.svg" alt="" style="width: 60px;"><br/>' . $variant->asset->file_original_name . '.' . $variant->asset->extension;
                                }
                            @endphp
                        </div>
                    </th>
                @endif
                <th class="table-column-ps-0">
                    <div class="btn-group" role="group" aria-label="Edit group">
                        <a class="btn btn-white pull-right pt-0" href="javascript:;"
                            onclick="deletevarient({{ $k }})">
                            <i class="bi-trash"></i>
                        </a>
                    </div>
                </th>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center"> No data found </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="modal fade" id="product_file_modal" tabindex="-1" aria-labelledby="uploadFilesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFilesModalLabel">Select File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab"
                            aria-controls="media" aria-selected="false">Media</a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab"
                            aria-controls="upload" aria-selected="false">Upload</a>
                    </li>
                </ul>
                <div class="tab-content" id="TabContent">
                    <div class="tab-pane fade show active" id="media" role="tabpanel"
                        aria-labelledby="media-tab">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4" id="file_container">
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <!-- Dropzone -->
                        <div id="attachFilesNewProjectLabel" class="js-dropzone dz-dropzone dz-dropzone-card">
                            <div class="dz-message">
                                <img class="avatar avatar-xl avatar-4x3 mb-3"
                                    src="{{ asset('assets/img/icons') }}/oc-browse.svg" alt="Image Description"
                                    data-hs-theme-appearance="default">
                                <h5>Drag and drop your file here</h5>

                                <p class="mb-2">or</p>

                                <span class="btn btn-white btn-sm" id="browse"
                                    onclick='return uploadPrepareAjax(0,1 )'>Browse
                                    files</span>
                                <input type="file" id='prepare_images' name="file" multiple
                                    style="display: none">
                            </div>
                        </div>
                        <span class="btn btn-success btn-sm" id="browse" onclick='return upload()'>Upload</span>
                        <!-- End Dropzone -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product_asset_modal" tabindex="-1" aria-labelledby="uploadFilesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFilesModalLabel">Select File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab"
                            aria-controls="media" aria-selected="false">Media</a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab"
                            aria-controls="upload" aria-selected="false">Upload</a>
                    </li>
                </ul>
                <div class="tab-content" id="TabContent">
                    <div class="tab-pane fade show active" id="media" role="tabpanel"
                        aria-labelledby="media-tab">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4"
                            id="file_asset_container">
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <!-- Dropzone -->
                        <div id="attachFilesNewProjectLabel" class="js-dropzone dz-dropzone dz-dropzone-card">
                            <div class="dz-message">
                                <img class="avatar avatar-xl avatar-4x3 mb-3"
                                    src="{{ asset('assets/img/icons') }}/oc-browse.svg" alt="Image Description"
                                    data-hs-theme-appearance="default">
                                <h5>Drag and drop your file here</h5>

                                <p class="mb-2">or</p>

                                <span class="btn btn-white btn-sm" id="browse"
                                    onclick='return uploadPrepareAjax(0,1 )'>Browse
                                    files</span>
                                <input type="file" id='prepare_images' name="file" multiple
                                    style="display: none">
                            </div>
                        </div>
                        <span class="btn btn-success btn-sm" id="browse"
                            onclick='return uploadAsset()'>Upload</span>
                        <!-- End Dropzone -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var selectedId = 0;

    function fileSelect(i) {
        selectedId = i;

        $.ajax({
            url: "{{ route('backend.file.show') }}",
            success: function(data) {
                if (!$.trim($('#fileManagerContainer').html()))
                    $('#fileManagerContainer').html(data);

                $('#fileManagerModal').modal('show');

                var selectedValue = $(`#variant-${selectedId}-thumbnail`).val();

                const getSelectedItem = function(selectedIdP, filePath) {
                    $(`#variant-${selectedId}-thumbnail`).val(selectedIdP);
                    $(`#selected_${selectedId}_image`).html(`<img src='${filePath}' style='width: 150px;height: 100px;'/>`);
                }

                setSelectedItemsCB(getSelectedItem, [selectedValue], false);
            }
        })
    }

    function assetSelect(i) {
        selectedId = i;

        $.ajax({
            url: "{{ route('backend.file.show') }}",
            success: function(data) {
                if (!$.trim($('#fileManagerContainer').html()))
                    $('#fileManagerContainer').html(data);

                $('#fileManagerModal').modal('show');

                var selectedValue = $(`#variant-${selectedId}-assets`).val();

                const getSelectedItem = function(selectedIdP, filePath) {
                    $(`#variant-${selectedId}-assets`).val(selectedIdP);
                    $(`#selected_${selectedId}_asset`).html('<img src="{{ asset("/assets/img/file.svg") }}" alt="" style="width: 60px;">');
                }

                setSelectedItemsCB(getSelectedItem, [selectedValue], false);
            }
        })
    }


    function upload() {
        uploadAjax(0, 1, " ");
        setTimeout(() => {
            fileSelect(selectedId);
        }, 500);
    }


    function uploadAsset() {

        uploadAjax(0, 1, " ");
        setTimeout(() => {
            assetSelect(selectedId);
        }, 500);
    }

    // $.ajax({
    //     url: "{{ route('backend.products.attributes.getproductattribute') }}",
    //     data: {
    //         product_id: {{ $product_id }}
    //     },
    //     success: function(variants) {
    //         var asset = "{{ asset('/uploads/all') }}";

    //         variants.map(function(variant) {
    //             var attribute = variant.variant_attribute_value.replace(',', '_');

    //             $(`#variant_price_${attribute}`).val(variant.variant_price / 100);
    //             $(`#variant_sku_${attribute}`).val(variant.variant_sku);
    //             $(`#variant_id_${attribute}`).val(variant.id);
    //             $(`#variant_quantity_${attribute}`).val(variant.variant_quantity ? variant
    //                 .variant_quantity : 1);
    //             $(`.variant_thumbnail_${attribute}`).val(variant.variant_thumbnail);
    //             $(`.variant_thumbnail_${attribute}`).next().html(
    //                 `<img src='${asset + '/' + variant.uploads.file_name}' style='width:150px;height:100px;'/>`
    //                 );
    //         })
    //     }
    // })
</script>
