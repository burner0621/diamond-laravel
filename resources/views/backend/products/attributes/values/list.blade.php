@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Products Attributes', 'navName' => 'attributes', 'activeButton' => 'products'])

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title"> Attribute Values for {{ $attribute->name }}</h1>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->



    <!-- Card -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header card-header-content-md-between">
                    <div class="mb-2 mb-md-0">
                        <h3 class="card-header-title mb-0">Add Value</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.products.attributes.values.store', $attribute->id) }}" method="POST">
                        @csrf
                        @if ($errors->has('name'))
                            <div class="col-md-12 mb-2">
                                <span class="badge btn-danger col-md-12"> value name is required </span>
                            </div>
                        @endif
                        <div class="col-md-12 mb-2">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" value="" class="form-control">

                        </div>

                        @if($attribute->type != 0)
                        <div class="col-md-12 mb-2">
                            <label for="name">Value:</label>
                            @if($attribute->type == 1)
                            <input type="color" name="value" id="name" value="" class="form-control">
                            @elseif($attribute->type == 2)
                            <div class="imagePreview img-thumbnail p-2">
                                <img id="fileManagerPreview" src="" style="width: 100%">
                            </div>
                            <input type="hidden" name="value" id="image_value" value="" class="form-control">
                            <label class="btn text-primary mt-2 p-0" id="getFileManager">Select Image</label>
                            @else($attribute->type == 0)
                            <input type="text" name="value" id="name" value="" class="form-control">
                            @endif
                        </div>
                        @else
                            <input type="hidden" name="value" id="name" value="{{ $attribute->name }}" class="form-control">
                        @endif
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary col-md-12"> Add to {{ $attribute->name }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header card-header-content-md-between">
                    <div class="mb-2 mb-md-0">
                        <h3 class="card-header-title mb-0">{{ $attribute->name }}</h3>
                    </div>
                </div>
                <div class="datatable-custom position-relative">
                    <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
                        <table id="datatable"
                            class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer table-responsive" role="grid" aria-describedby="datatable_info">
                            <thead class="thead-light">
                                <tr role="row">
                                    <th class="table-column-pe-0 sorting_disabled" aria-label="">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="datatableCheckAll">
                                            <label class="form-check-label" for="datatableCheckAll"></label>
                                        </div>
                                    </th>
                                    <th class="sorting" aria-label="">ID</th>
                                    <th class="sorting_disabled" tabindex="0" aria-controls="datatable" aria-label="Name: activate to sort column ascending">Name</th>
                                    <th class="sorting_disabled" tabindex="0" aria-controls="datatable" aria-label="Name: activate to sort column ascending">Slug</th>
                                    <th class="sorting_disabled" tabindex="0" aria-controls="datatable" aria-label="Name: activate to sort column ascending">Value</th>
                                    <th class="sorting_disabled"aria-label="">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($values as $value)
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                                <label class="form-check-label" for="ordersCheck1"></label>
                                            </div>
                                        </td>
                                        <td> {{ $value->id }} </td>
                                        <td> {{ $value->name }} </td>
                                        <td> {{ $value->slug }} </td>
                                        <td>
                                            @if ($attribute->type == 1)
                                                <span class="h-20px w-20px d-block" style="background:{{$value->value}}"></span>
                                            @elseif($attribute->type == 2)
                                                <img class="" src="{{ $value->image ? $value->image->getImageOptimizedFullName() : ''}}" style="width:100px"/>
                                            @else
                                            {{ $value->name }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-dark btn-sm" href="{{ route('backend.products.attributes.values.edit', ['id_attribute' => $attribute->id , 'id' => $value->id]) }}">Edit</a>
                                                <!-- Button Group -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                                        <a class="dropdown-item text-danger" href="{{ route('backend.products.attributes.values.delete', ['id_attribute' => $attribute->id , 'id' => $value->id]) }}">Delete</a>
                                                    </div>
                                                </div>
                                                <!-- End Unfold -->
                                            </div>
                                            <!-- End Button -->
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to
                            15
                            of 24
                            entries</div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                        <div class="col-sm mb-2 mb-sm-0">

                            <div class="col-sm-auto">
                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <!-- Pagination -->
                                    <nav id="datatablePagination" aria-label="Activity pagination">
                                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                            <ul id="datatable_pagination" class="pagination datatable-custom-pagination">
                                                <li class="paginate_item page-item disabled">
                                                    <a class="paginate_button previous page-link" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous">
                                                <span aria-hidden="true">Prev</span>
                                                </a>
                                                </li>
                                                <li class="paginate_item page-item active"><a
                                                        class="paginate_button page-link" aria-controls="datatable"
                                                        data-dt-idx="1" tabindex="0">1</a></li>
                                                <li class="paginate_item page-item"><a class="paginate_button page-link"
                                                        aria-controls="datatable" data-dt-idx="2" tabindex="0">2</a>
                                                </li>
                                                <li class="paginate_item page-item"><a
                                                        class="paginate_button next page-link" aria-controls="datatable"
                                                        data-dt-idx="3" tabindex="0" id="datatable_next"><span
                                                            aria-hidden="true">Next</span></a></li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div id="fileManagerContainer"></div>

    <!-- End Card -->
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {
            $('#name').keyup(function() {
                var slug = $(this).val()

                if (slug.charAt(slug.length - 1) != " ") {
                    $('#slug').val(slug.replace(/\s+/g, '-').toLowerCase());
                }

            })
        })

        $('#getFileManager').click(function () {
            $.ajax({
                url: "{{ route('backend.file.show') }}",
                success: function (data) {
                    if (!$.trim($('#fileManagerContainer').html()))
                        $('#fileManagerContainer').html(data);

                    $('#fileManagerModal').modal('show');

                    const getSelectedItem = function (selectedId, filePath) {

                        $('#image_value').val(selectedId);
                        $('#fileManagerPreview').attr('src', filePath);
                    }

                    setSelectedItemsCB(getSelectedItem, $('#image_value').val() == '' ? [] : [$('#image_value').val()], false);
                }
            })
        });

    </script>
@endsection
