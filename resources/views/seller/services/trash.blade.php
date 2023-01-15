@extends('backend.layouts.app', ['activePage' => 'services', 'title' => 'All service', 'navName' => 'servicetrash', 'activeButton' => 'service'])

@section('content')
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Trash <span class="badge bg-soft-dark text-dark ms-2">72,031</span></h1>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card rounded-0">
                        <div class="datatable-custom position-relative">
                                <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover no-footer table-responsive">
                                    <thead class="thead-light">
                                        <th class="table-column-pe-0 sorting_disabled" aria-label="">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                                <label class="form-check-label" for="datatableCheckAll"></label>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Author</th>
                                        <th>Categories</th>
                                        <th>Actions</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($services as $service)
                                        <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                                <label class="form-check-label" for="ordersCheck1"></label>
                                            </div>
                                        </td>
                                        <td>{{ $service->id }}</td>
                                       
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->slug }}</td>
                                        <td>{{ $service->serviceauthor->name }}</td>
                                        <td>
                                            @foreach($service->categories as $category_info)
                                                <p><span class="badge btn-info"> {{$category_info->category->category_name}} </span>  </p>
                                            @endforeach
                                        </td>
                                        <td>
                                                <a class="btn btn-dark btn-sm" href="{{ route('backend.services.recover', $service->id)}}"> <i class="bi-restore"></i> Restore </a>
                                              
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

                ajax: '{{ route('backend.services.get') }}',
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
