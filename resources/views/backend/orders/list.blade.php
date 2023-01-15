@extends('backend.layouts.app', ['activePage' => 'orders', 'title' => 'All Orders', 'navName' => 'orderslist', 'activeButton' => 'catalogue'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">All Orders</h1>
    </div>
    <!-- End Row -->
</div>  

<div class="card">
    <div class="card-header card-header-content-md-between">
        <div class="row">
            <div class="mb-2 mb-md-0">
                <h4 class="card-title">Orders</h4>
                <p class="card-category">Manage orders</p>
            
            </div>
        </div>
    </div>
    <div class="table-responsive datatable-custom">
        <table class="table table-hover table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer">
            <thead class="thead-light">
                <tr role="row">
                    <th class="table-column-pe-0 sorting_disabled" aria-label="">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                            <label class="form-check-label" for="datatableCheckAll"></label>
                        </div>
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Order: activate to sort column ascending">Order</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Payment status: activate to sort column ascending">Order Total</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Date: activate to sort column ascending">Date</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Customer: activate to sort column ascending">Customer</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Fulfillment status: activate to sort column ascending">Payment status</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Fulfillment status: activate to sort column ascending">Fulfillment status</th>
                    <th class="sorting" tabindex="0" aria-controls="datatable" aria-label="Actions: activate to sort column ascending">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="table-column-pe-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ordersCheck1">
                                <label class="form-check-label" for="ordersCheck1"></label>
                            </div>
                        </td>
                        <td><a href="javascript:;" class="link-primary">#{{$order->order_id}}</a></td>
                        <td>${{$order->total_price}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>
                            <a href="{{route('user.index', $order->user_id)}}" class="link-primary">
                                {{$order->email}}
                            </a>
                        </td>
                        <td title="{{ $order->status_payment_reason }}">
                            {{Config::get('constants.oder_payment_status')[$order->status_payment]}}
                        </td>
                        <td>
                            @php
                              $status = 'Fulfilled';
                              foreach ($order->items as $key => $item) {
                                  if ($item->status_fulfillment == '1') {
                                      $status = 'Unfulfilled';
                                  }
                              }
                              echo $status;
                            @endphp
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-dark btn-sm" href="{{ route('backend.orders.show', $order->id) }}">View</a>
                                <!-- Button Group -->
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                        <span class="dropdown-header">Options</span>
                                        <a class="js-export-print dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/illustrations/print-icon.svg" alt="Image Description"/>
                                            Print
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <span class="dropdown-header">Download options</span>
                                        <a class="js-export-excel dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/brands/excel-icon.svg" alt="Image Description"/>
                                            Excel
                                        </a>
                                        <a class="js-export-csv dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/components/placeholder-csv-format.svg" alt="Image Description" />
                                            .CSV
                                        </a>
                                        <a class="js-export-pdf dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/brands/pdf-icon.svg" alt="Image Description"/>
                                            PDF
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:;"> <i class="bi-trash dropdown-item-icon"></i> Delete </a>
                                    </div>
                                </div> --}}
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
<div class="text-center">
    {{$orders->links()}}
</div>
@endsection
