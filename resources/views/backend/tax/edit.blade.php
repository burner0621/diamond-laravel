@extends('backend.layouts.app', ['activePage' => 'tax', 'title' => 'Tax', 'navName' => 'tax', 'activeButton' => 'catalogue'])

@section('content')
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('backend.tax.index') }}">Tax</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Tax</li>
                    </ol>
                </nav>

                <h1 class="page-header-title">Edit Tax</h1>

                <div class="mt-2">
                    <a class="text-body me-3" href="javascript:;">
                        <i class="bi-clipboard me-1"></i> Duplicate
                    </a>
                    <a class="text-body" href="#">
                        <i class="bi-eye me-1"></i> Preview
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('backend.tax.update', $tax->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <div class="offset-md-4 col-sm-4">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $tax->name }}" id="name" class="form-control"
                        required placeholder="Enter Name">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-md-4 col-sm-4">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="{{ $tax->price / 100 }}" id="price" class="form-control"
                        required placeholder="Enter Price">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-md-4 col-sm-4">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type">
                        <option value="percent" @if ($tax->type == 'percent') selected @endif>percent</option>
                        <option value="flat" @if ($tax->type == 'flat') selected @endif>flat</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
              <div class="offset-md-4 col-sm-4">
                <button type="submit" class="btn btn-primary float-end">Submit</button>
              </div>
            </div>
        </form>
    </div>
@endsection
