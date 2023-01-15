@extends('backend.layouts.app', ['activePage' => 'withdraws', 'title' => "Withdaw Methods", 'navName' => 'withdrawmethods', 'activeButton' => 'laravel']) 
@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-no-gutter">
			<li class="breadcrumb-item active" aria-current="page">Payment Methods</li>
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
						<th class="sorting" tabindex="0" aria-controls="datatable">Name</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Question 1</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Question 2</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Question 3</th>
						<th class="sorting" tabindex="0" aria-controls="datatable">Question 4</th>
						<th class="sorting_disabled" aria-label="">Actions</th>
					</tr>
				</thead>
				<tbody> 
          @foreach ($methods as $method) 
            <tr role="row" class="odd">
						  <td class="table-column-ps-0">
                {{ $method->name }}
						  </td>
						  <td>{{ $method->question_1 }}</td>
						  <td>{{ $method->question_2 }}</td>
						  <td>{{ $method->question_3 }}</td>
						  <td>{{ $method->question_4 }}</td>
              <td>
                <div class="btn-group" role="group">
									<a href="{{ route('backend.withdraws.method.edit', $method->id) }}" class="btn btn-primary">Edit</a>
									<a href="{{ route('backend.withdraws.method.delete', $method->id) }}" class="btn btn-danger" href="javascript:;">Delete</a>
                </div>
                <!-- End Button -->
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
