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
              <div class="col-md-12">
                  <h3>Withdraw History</h3>
              </div>
              <div class="col-3">
                  <x-dashboard-side-bar />
              </div>
              <div class="col-md-9">
                  <div class="card rounded-0">
                      <div class="datatable-custom position-relative">
                          <table class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-responsive no-footer">
                              <thead class="thead-light">
                                  <th>Amount</th>
                                  <th>Status</th>
                                  <th>Payment Method</th>
                                  <th>Data 1</th>
                                  <th>Data 2</th>
                                  <th>Data 3</th>
                                  <th>Data 4</th>
                              </thead>

                              <tbody>
                                  @foreach ($histories as $history)
                                  <tr>
                                  <td>${{ number_format($history->amount, 2) }}</td>
                                  <td>{{ $history->status ? "Finished" : "Pending" }}</td>
                                  <td>{{ $history->payment_method_name }}</td>
                                  <td>{{ $history->q1 }}</td>
                                  <td>{{ $history->q2 }}</td>
                                  <td>{{ $history->q3 }}</td>
                                  <td>{{ $history->q4 }}</td>
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
</x-app-layout>

@section('js')
  <script>
  </script>
@endsection
