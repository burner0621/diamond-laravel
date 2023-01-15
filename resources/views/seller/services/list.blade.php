<x-app-layout>
    <style>
        .pur {
            width: 100%;
            margin-bottom: 8px;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-9">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-dashboard-side-bar />
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-primary" href="{{route('seller.services.create')}}">Create Service</a>
                        </div>
                        <div class="card-body">
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
                                        <!--<td>{{ $service->slug }}</td>-->
                                        <td>{{ $service->postauthor->first_name }} {{ $service->postauthor->last_name }}</td>
                                        <td>
                                            @foreach($service->categories as $category_info)
                                                <span>{{$category_info->category->category_name}}</span> 
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-dark btn-sm" href="{{ route('seller.services.edit', $service->id) }}">Edit</a>
                                                <!-- Button Group -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                                        <span class="dropdown-header">Options</span>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this service?')" href="{{route('seller.services.delete', $service->id)}}">Delete</a>
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
            </div>
        </div>
    </div>
</x-app-layout>

@section('js')
    <script>
        $(function() {
            $('.select2').select2({
                tags: true,
                maximumSelectionLength: 10,
                tokenSeparators: [','],
                placeholder: "Select or type keywords",
            })
        });
    </script>
@endsection
