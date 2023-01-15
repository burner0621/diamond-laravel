@extends('backend.layouts.app', ['activePage' => 'withdraws', 'title' => "Withdaw Methods", 'navName' => 'withdraws', 'activeButton' => 'laravel'])
@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-no-gutter">
			<li class="breadcrumb-item active" aria-current="page">Withdraws</li>
		</ol>
		<a href="{{ route('backend.withdraws.method.add') }}" class="btn btn-primary">New Payment Method</a>
	</nav>
	<!-- End Row -->
</div>
<!-- End Page Header -->

@if (session('success'))
<h4 class="text-center text-primary mt-3">
		{{session('success')}}
</h4>
@endif
@if (session('error'))
<h4 class="text-center text-danger mt-3">
		{{session('error')}}
</h4>
@endif

<!-- Card -->
<div class="mb-4">
	<div class="datatable-custom position-relative mb-4">
		<div id="datatable_wrapper" class="border dataTables_wrapper no-footer">
			<table id="datatable" class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover table-responsive no-footer mb-0" role="grid" aria-describedby="datatable_info">
				<thead class="thead-light">
					<tr role="row">
						<th class="sorting" tabindex="0" aria-controls="datatable">Seller name</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Payment Method</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Amount</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable">Question 1</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable">Question 2</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable">Question 3</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable">Question 4</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Status</th>
					</tr>
				</thead>
				<tbody>
          @foreach ($withdraws as $withdraw)
            <tr role="row" class="odd">
						  <td class="table-column-ps-0">
                {{ $withdraw->user->first_name . " " . $withdraw->user->last_name }}
						  </td>
						  <td>{{ $withdraw->payment_method_name }}</td>
						  <td>${{ number_format($withdraw->amount / 100, 2) }}</td>
                          <td>{{ $withdraw->q1 }}</td>
                          <td>{{ $withdraw->q2 }}</td>
                          <td>{{ $withdraw->q3 }}</td>
                          <td>{{ $withdraw->q4 }}</td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenuButton_{{$withdraw->id}}" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Config::get('constants.withdraw_status')[$withdraw->status] }}
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{$withdraw->id}}">
                    <li><a href="{{ route('backend.withdraws.status.pending', $withdraw->id) }}" class="dropdown-item" href="#">Pending</a></li>
                    <li><a href="{{ route('backend.withdraws.status.finished', $withdraw->id) }}" class="dropdown-item" href="#">Finished</a></li>
                    <li><a href="{{ route('backend.withdraws.status.rejected', $withdraw->id) }}" class="dropdown-item" href="#">Rejected</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
			</table>
			{{-- <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to 15 of 24 entries</div> --}}
		</div>
	</div>
</div>
@endsection

@section('js_content')
    <script>
    </script>
@endsection
