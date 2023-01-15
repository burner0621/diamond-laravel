@extends('backend.layouts.app', ['activePage' => 'services', 'title' => 'service Tags', 'navName' => 'servicetags', 'activeButton' => 'laravel'])

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title">Service Tags</h1>
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
                        <h3 class="card-header-title mb-0">Add Tag</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.service.tags.store') }}" method="POST">
                        @csrf
                        @if ($errors->has('name'))
                            <div class="col-md-12 mb-2">
                                <span class="badge btn-danger col-md-12"> Tag name is required </span>
                            </div>
                        @endif
                        <div class="col-md-12 mb-2">
                            <label for="name" class="w-100 mb-2">Tag name:</label>
                            <input type="text" name="name" id="name" value="" class="form-control">

                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="name" class="w-100 mb-2">Slug:</label>
                            <input type="text" name="slug" id="slug" value="" class="form-control">

                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="name" class="w-100 mb-2">Description:</label>
                            <textarea type="text" name="description" id="name" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_title" class="w-100 mb-2">Meta Title:</label>
                            <input type="text" name="meta_title" id="meta_title" value="" class="form-control">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_description" class="w-100 mb-2">Meta Description:</label>
                            <textarea type="text" name="meta_description" id="meta_description" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary col-md-12"> Add </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card rounded-0 mb-4">
                <div class="card-header card-header-content-md-between">
                    <div class="mb-2 mb-md-0">
                        <h3 class="card-header-title mb-0">Tags</h3>
                    </div>
                </div>
                <div class="datatable-custom position-relative">
                    <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
                        <table id="datatable" class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover table-responsive no-footer" role="grid" aria-describedby="datatable_info">
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
                                    <th class="sorting_disabled"aria-label="">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                                <label class="form-check-label" for="ordersCheck1"></label>
                                            </div>
                                        </td>
                                        <td> {{ $tag->id }} </td>
                                        <td> {{ $tag->name }} </td>
                                        <td> {{ $tag->slug }} </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-dark btn-sm" href="{{ route('backend.service.tags.edit', $tag->id) }}">Edit</a>
                                                <!-- Button Group -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                                        <span class="dropdown-header">Options</span>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this product?')" href="{{ route("backend.service.tags.delete", $tag->id) }}">Delete</a>
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
                        <!-- <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to
                            15
                            of 24
                            entries</div> -->
                    </div>
                </div>

                <!-- <div class="card-footer">
                    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                        <div class="col-sm mb-2 mb-sm-0">

                            <div class="col-sm-auto">
                                <div class="d-flex justify-content-center justify-content-sm-end">
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
                        </div>
                    </div>
                </div> -->
                <div class="text-center">
                    {{$tags->links()}}
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- End Card -->
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {
            // $('#name').keyup(function() {
            //     var slug = $(this).val()

            //     if (slug.charAt(slug.length - 1) != " ") {
            //         $('#slug').val(slug.replace(/\s+/g, '-').toLowerCase());
            //     }
            // })
        })
    </script>
@endsection
