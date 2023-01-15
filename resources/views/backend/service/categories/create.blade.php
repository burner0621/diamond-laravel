@extends('backend.layouts.app', ['activePage' => 'services', 'title' => 'Create Category', 'navName' => 'servicecategories', 'activeButton' => 'service'])

@section('content')
            <div class="page-header">
                <div class="row align-items-end">
                    <h1 class="page-header-title">Create Category</h1>
                </div>
                <!-- End Row -->
            </div>   

            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('backend.service.categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="card col-md-12">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">Category information</h4>
                                </div>
                                <!-- End Header -->
                                <div class="card-body row">
                                    @include('includes.validation-form')
                                    <div class="col-md-12 mb-2">
                                        <label for="name">Name</label>
                                        <input type="text" name="category_name" id="name" value="{{ old('category_name') }}" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Parent</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="selectpicker" name="parent_id" data-live-search="true">
                                                    <option selected disabled>None</option>
                                                    @foreach ($categories as $categorie)
                                                        <option value="{{$categorie->id}}" data-tokens="{{$categorie->category_name}}">{{$categorie->category_name}}</option>
                                                    @endforeach
                                                    
                                                  </select>
                                            </div>
                                        </div>
                                        
                                          
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Slug:</label>
                                        <input type="text" name="slug" id="slug" value="" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="desc">Description:</label>
                                        <textarea name="category_excerpt" id="desc" rows="3" class="form-control">
                                            {{ old('category_excerpt') }}
                                        </textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-lg btn-outline-success">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-12">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">Meta information</h4>
                                </div>
                                <!-- End Header -->
                                <div class="card-body row">
                                    <div class="col-md-12 mb-2">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="meta_desc">Meta Description:</label>
                                        <textarea name="meta_description" id="meta_desc" rows="3" class="form-control">
                                            {{ old('meta_description') }}
                                        </textarea>
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
            $('#desc').trumbowyg();
            $('#meta_desc').trumbowyg();
            // $('#name').keyup(function(){
            //     var slug = $(this).val()
                
            //     if(slug.charAt(slug.length - 1) != " ")
            //     {
            //         $('#slug').val(slug.replace(/\s+/g, '-').toLowerCase());
            //     }
                
            // })
         })
    </script> 
    @endsection
