<x-app-layout>
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
                            <ul class="nav nav-tabs seller-nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link {{ $tab == "active" ? "active" : "" }}" href="?tab=active">Active</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tab == "late" ? "active" : "" }}" href="?tab=late">Late</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tab == "delivered" ? "active" : "" }}" href="?tab=delivered">Delivered</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tab == "completed" ? "active" : "" }}" href="?tab=completed">Completed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tab == "canceled" ? "active" : "" }}" href="?tab=canceled">Cancelled</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="datatable-custom position-relative">
                                <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-responsive no-footer">
                                    <thead class="thead-light">
                                        <th>Buyer</th>
                                        <th>Service Name - Package</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Delivery Date</th>
                                        <th>Actions</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                            <td>{{ $order->service->name . " - " . ($order->package_name) }}</td>
                                            <td>${{ number_format($order->package_price / 100, 2) }}</td>
                                            <td>
                                                @if ($order->status == 0)
                                                Pending
                                                @elseif ($order->status == 1)
                                                In Progress
                                                @elseif ($order->status == 2)
                                                Revision
                                                @elseif ($order->status == 3)
                                                Canceled
                                                @else
                                                Delivered
                                                @endif
                                            </td>
                                            <td>{{ $order->status == 0 ? "-" : date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-dark btn-sm" href="{{ route('seller.service.order.detail', $order->order_id) }}">View</a>
                                                </div>
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
  </script>
@endsection
