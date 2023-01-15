@extends('backend.layouts.app', ['activePage' => 'courses', 'title' => 'All Course', 'navName' => 'allcourse', 'activeButton' => 'blog'])

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">
    <nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-no-gutter">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('backend.courses.list') }}">Courses</a></li>
			<li class="breadcrumb-item active" aria-current="page">All Courses</li>
		</ol>
	</nav>
    <div class="row align-items-center mb-3">
        <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Course <span class="badge bg-soft-dark text-dark ms-2">{{ count($courses) }}</span></h1>
        </div>
        <!-- End Col -->

        <div class="col-sm-auto">
            <a class="btn btn-primary" href="{{ route('backend.courses.create') }}">Create course</a>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="datatable-custom position-relative">
                <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-responsive no-footer">
                    <thead class="thead-light">
                        <th class="sorting_disabled" aria-label="">
                            <div class="form-checkbox">
                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </thead>

                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td class="table-column-pe-0">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                        <label class="form-check-label" for="ordersCheck1"></label>
                                    </div>
                                </td>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->name }}</td>
                                <td>${{ $course->price }}</td>
                                <td>{{ $course->category_name }}</td>
                                <td>{{ $course->author_name }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-dark btn-sm" href="{{ route('backend.courses.edit', $course->id) }}">Edit</a>
                                        <!-- Button Group -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                                <span class="dropdown-header">Options</span>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this course?')" href="{{route('backend.courses.delete', $course->id)}}">Delete</a>
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
        ajax: '{{ route('backend.courses.get') }}',
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'slug',
            name: 'slug'
        },
        {
            data: 'categorie_id',
            name: 'categorie_id'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }]
    });
});
</script>
@endsection
