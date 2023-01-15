@extends('backend.layouts.app', ['activePage' => 'tax', 'title' => 'Tax', 'navName' => 'tax', 'activeButton' => 'catalogue'])

@section('content')
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">Tax <span class="badge bg-soft-dark text-dark ms-2"></span></h1>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{ route('backend.tax.create') }}">Create Tax</a>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card strpied-tabled-with-hover rounded-0">
                <div class="datatable-custom">
                    <div class="col-md-12">
                        <table
                            class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover table-responsive no-footer">
                            <thead class="thead-light">
                                <th class="sorting_disabled" aria-label="">
                                    <div class="form-checkbox">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="datatableCheckAll">
                                        <label class="form-check-label" for="datatableCheckAll"></label>
                                    </div>
                                </th>
                                <th class="sorting">ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @php
                                  $nIndex = 0;
                                @endphp
                                @foreach ($taxes as $tax)
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                                <label class="form-check-label" for="ordersCheck1"></label>
                                            </div>
                                        </td>
                                        <td>{{ ++$nIndex }}</td>
                                        <td>{{ $tax->name }}</td>
                                        <td>{{ $tax->type }}</td>
                                        <td>{{ $tax->price / 100 }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-dark btn-sm"
                                                    href="{{ route('backend.tax.edit', $tax->id) }}">Edit</a>
                                                <!-- Button Group -->
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty"
                                                        id="ordersExportDropdown1" data-bs-toggle="dropdown"
                                                        aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-end mt-1"
                                                        aria-labelledby="ordersExportDropdown1" style="">
                                                        <span class="dropdown-header">Options</span>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('backend.tax.destroy', $tax->id) }}" method="post">
                                                          @csrf
                                                          @method('delete')                                                            
                                                            <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this tax?')" >Delete</button>
                                                        </form>
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
@endsection
