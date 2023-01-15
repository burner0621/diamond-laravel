@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Products Attributes', 'navName' => 'attributes', 'activeButton' => 'products']) @section('content')
<!-- Page Header -->
<div class="page-header mb-4">
	<div class="row align-items-end">
		<h1 class="page-header-title">Product Attributes <span class="badge bg-soft-dark text-dark ms-2">72,031</span>
		</h1>
	</div>
	<!-- End Row -->
</div>
<!-- End Page Header -->
<!-- Card -->
<div class="row">
	<div class="col-lg-4">
		<div class="card mb-4">
			<div class="card-header card-header-content-md-between">
				<div class="mb-2 mb-md-0">
					<h3 class="card-header-title mb-0">Add Attribute</h3>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('backend.products.attributes.store') }}" method="POST"> 
                    @csrf @if ($errors->has('name')) 
                    <div class="col-md-12 mb-2">
						<span class="badge btn-danger col-md-12"> Tag name is required </span>
					</div> 
                    @endif 
                    <div class="col-md-12 mb-2">
						<label for="name">Name:</label>
						<input type="text" name="name" id="name" value="" class="form-control">
					</div>
					<div class="col-md-12 mb-2">
						<label for="name">Type:</label>
						<div class="row">
							<div class="col-md-12">
								<select class="selectpicker col-md-12" name="type" data-live-search="true">
									<option value="0" data-tokens="">Select</option>
									<option value="1" data-tokens="">Color</option>
									<option value="2" data-tokens="">Image</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12 mb-2">
						<button type="submit" class="btn btn-primary col-md-12"> Add </button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card rounded-0 mb-4">
			<div class="card-header card-header-content-md-between">
				<div class="mb-2 mb-md-0">
					<h3 class="card-header-title mb-0">Attributes</h3>
				</div>
			</div>
			<div class="datatable-custom position-relative">
				<div id="datatable_wrapper" class="dataTables_wrapper no-footer">
					<table id="datatable" class="table table-lg table-thead-bordered table-nowrap table-align-middle card-table dataTable table-hover no-footer table-responsive" role="grid" aria-describedby="datatable_info">
						<thead class="thead-light">
							<tr role="row">
								<th class="sorting_disabled" aria-label="">
									<div class="form-checkbox">
										<input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
										<label class="form-check-label" for="datatableCheckAll"></label>
									</div>
								</th>
								<th class="sorting" aria-label="">ID</th>
								<th class="sorting_disabled" tabindex="0" aria-controls="datatable">Name</th>
								<th class="sorting_disabled" tabindex="0" aria-controls="datatable">Slug</th>
								<th class="sorting_disabled" tabindex="0" aria-controls="datatable">Type</th>
								<th class="sorting_disabled" aria-label="">Actions</th>
							</tr>
						</thead>
						<tbody> 
                            @foreach ($attributes as $attribute) 
                            <tr>
								<td class="table-column-pe-0">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="ordersCheck1">
										<label class="form-check-label" for="ordersCheck1"></label>
									</div>
								</td>
								<td> {{ $attribute->id }} </td>
								<td> {{ $attribute->name }} </td>
								<td> {{ $attribute->slug }} </td>
								<td> @if ($attribute->type == 1) Color @elseif($attribute->type == 2) Image @else Text @endif </td>
								<td>
									<div class="btn-group" role="group">
                                        <a class="btn btn-dark btn-sm" href="{{ route('backend.products.attributes.values.list', $attribute->id) }}">Values</a>
                                        <!-- Button Group -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-dark btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1" style="">
                                                <a class="dropdown-item" href="{{ route('backend.products.attributes.edit', $attribute->id) }}">Edit</a>
                                                <a class="dropdown-item text-danger attribute-delete-btn" href="{{ route('backend.products.attributes.delete', $attribute->id) }}">Delete</a>
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
					<!-- <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to 15 of 24 entries</div> -->
				</div>
			</div>
			<!-- <div class="card-footer">
				<div class="row justify-content-center justify-content-sm-between align-items-sm-center">
					<div class="col-sm mb-2 mb-sm-0">
						<div class="col-sm-auto">
							<div class="d-flex justify-content-center justify-content-sm-end">
								<nav id="datatablePagination" aria-label="Activity pagination">
									<div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
										<ul id="datatable_pagination" class="pagination datatable-custom-pagination">
											<li class="paginate_item page-item disabled">
												<a class="paginate_button previous page-link" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous">
													<span aria-hidden="true">Prev</span>
												</a>
											</li>
											<li class="paginate_item page-item active">
												<a class="paginate_button page-link" aria-controls="datatable" data-dt-idx="1" tabindex="0">1</a>
											</li>
											<li class="paginate_item page-item">
												<a class="paginate_button page-link" aria-controls="datatable" data-dt-idx="2" tabindex="0">2</a>
											</li>
											<li class="paginate_item page-item">
												<a class="paginate_button next page-link" aria-controls="datatable" data-dt-idx="3" tabindex="0" id="datatable_next">
													<span aria-hidden="true">Next</span>
												</a>
											</li>
										</ul>
									</div>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<div class="text-center">
				{{$attributes->links()}}
			</div>
		</div>
	</div>
</div>

<!-- End Card --> 
@endsection 
@section('js_content') 
<script>
	$(document).ready(function() {
		$('#name').keyup(function() {
			var slug = $(this).val()
			if (slug.charAt(slug.length - 1) != " ") {
				$('#slug').val(slug.replace(/\s+/g, '-').toLowerCase());
			}
		})
		$('.attribute-delete-btn').click(function(e){
			if(confirm("Are you sure you want to delete this attribute")){
			}else{
				e.preventDefault();
			}
		})
	})
</script> 
@endsection
