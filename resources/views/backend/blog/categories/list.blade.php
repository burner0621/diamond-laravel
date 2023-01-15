@extends('backend.layouts.app', ['activePage' => 'posts', 'title' => 'Blog Categories', 'navName' => 'blogcategories', 'activeButton' => 'blog'])

@section('content')
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Blog Categories <span class="badge bg-soft-dark text-dark ms-2">72,031</span></h1>
        </div>
        <!-- End Col -->

        <div class="col-sm-auto">
            <a class="btn btn-primary" href="{{ route('backend.blog.categories.create') }}">Create category</a>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>  

<div class="row">
    <div class="col-md-12">
        <div class="card strpied-tabled-with-hover rounded-0">
            <div class="table-full-width">
                <div class="col-md-12">
                <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-responsive no-footer">
                    <thead>
                        <th class="sorting_disabled" aria-label="">
                            <div class="form-checkbox">
                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th class="sorting">ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>

                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @php
                            $nIndex = 0;
                        @endphp
                        @foreach ($categories as $categorie)
                        @php
                            $nIndex++;
                        @endphp
                        <tr>
                        <td class="table-column-pe-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                <label class="form-check-label" for="ordersCheck1"></label>
                            </div>
                        </td>
                        <td>{{ $categorie->id }}</td>
                        <td>{{ $categorie->category_name }}</td>
                        <td>{{ $categorie->slug }}</td>
                        <td>{{ $categorie->parent_id }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-dark btn-sm" href="{{ route('backend.blog.categories.edit', $categorie->id) }}">Edit</a>
                                @if ($nIndex != 1)
                                    <!-- Button Group -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                            <span class="dropdown-header">Options</span>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this product?')" href="{{ route("backend.blog.categories.delete", $categorie->id) }}">Delete</a>
                                        </div>
                                    </div>
                                    <!-- End Unfold -->
                                @endif
                            </div>
                            <!-- End Button -->

                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection

@section('js_content')
    <script>
        $(function() {

            $('.table').DataTable({
                processing: true,
                serverSide: true,
                bAutoWidth: false,
                ajax: '{{ route('backend.blog.categories.get') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
