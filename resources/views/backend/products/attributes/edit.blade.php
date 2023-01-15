@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Edit Attribute', 'navName' => 'attributes', 'activeButton' => 'products'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit Attribute</h1>
    </div>
    <!-- End Row -->
</div>  

<div class="row">
    <div class="col-md-12">
        <form action="{{route('backend.products.attributes.update', $attribute->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    @include('includes.validation-form')
                    <div class="col-md-6 mb-2">
                        <label for="name">Name:</label>
                        <input value="{{ $attribute->name }}" type="text" name="name" id="name" value="" class="form-control">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="name">Type:</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select class="selectpicker col-md-12" name="type" data-live-search="true">
                                    <option value="0"  data-tokens="">Select</option>
                                    <option value="1" @if($attribute->type == 1) selected @endif data-tokens="">Color</option>
                                    <option value="2" @if($attribute->type == 2) selected @endif data-tokens="">Image</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js_content')

<script>
    $(document).ready(function(){
    $('#name').keyup(function(){
        var slug = $(this).val()
        
        if(slug.charAt(slug.length - 1) != " ")
        {
            $('#slug').val(slug.replace(/\s+/g, '-').toLowerCase());
        }
        
    })
    })
</script> 
@endsection
