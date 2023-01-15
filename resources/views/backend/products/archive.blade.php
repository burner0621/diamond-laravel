@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'All Products', 'navName' => 'productsarchive', 'activeButton' => 'catalogue'])

@section('content')
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Archived Products <span class="badge bg-soft-dark text-dark ms-2">72,031</span></h1>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card rounded-0">
                        <div class="datatable-custom">
                            <div class="col-md-12">
                                <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover no-footer table-responsive">
                                    <thead class="thead-light">
                                        <th class="sorting_disabled" aria-label="">
                                            <div class="form-checkbox">
                                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                                <label class="form-check-label" for="datatableCheckAll"></label>
                                            </div>
                                        </th>
                                        <th class="sorting">ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>

                                            @foreach ($products as $product)
                                            <tr>
                                            <td class="table-column-pe-0">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                                    <label class="form-check-label" for="ordersCheck1"></label>
                                                </div>
                                            </td>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }} $</td>
                                            <td>{{ $product->qty }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td>

                                                    <a class="btn btn-dark btn-sm" href="{{ route('backend.products.recover', $product->id) }}"> <i class="bi-load"></i> Restore </a>

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

                ajax: '{{ route('backend.products.get') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'category',
                        name: 'category'
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
