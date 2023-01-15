@extends('backend.layouts.app', ['activePage' => 'posts', 'title' => 'All Post', 'navName' => 'allpost', 'activeButton' => 'blog'])

@section('content')

<!-- Page Header -->
<div class="page-header mb-4">
    <nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-no-gutter">
			<li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('backend.users.list') }}">Users</a></li>
			<li class="breadcrumb-item active" aria-current="page">All Users</li>
		</ol>
	</nav>
    <div class="row align-items-center mb-3">
        <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Post <span class="badge bg-soft-dark text-dark ms-2">72,031</span></h1>
        </div>
        <!-- End Col -->

        <div class="col-sm-auto">
            <a class="btn btn-primary" href="{{ route('backend.posts.create') }}">Create post</a>
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
                            <!--<th>Slug</th>-->
                            <th>Author</th>
                            <th>Categories</th>
                            <th>Actions</th>
                        </thead>

                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                            <td class="table-column-pe-0">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                    <label class="form-check-label" for="ordersCheck1"></label>
                                </div>
                            </td>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->name }}</td>
                            <!--<td>{{ $post->slug }}</td>-->
                            <td>{{ $post->postauthor->name }}</td>
                            <td>
                                @foreach($post->categories as $category_info)
                                    <span>{{$category_info->category->category_name}}</span> 
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-dark btn-sm" href="{{ route('backend.posts.edit', $post->id) }}">Edit</a>
                                    <!-- Button Group -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                            <span class="dropdown-header">Options</span>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?')" href="{{route('backend.posts.delete', $post->id)}}">Delete</a>
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

                ajax: '{{ route('backend.posts.get') }}',
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
                    },
                ]
            });
        });
    </script>
@endsection
