@extends('backend.layouts.app', ['activePage' => 'posts', 'title' => 'Edit Blog Category', 'navName' => 'Table List', 'activeButton' => 'blog'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit Blog Category</h1>
    </div>
    <!-- End Row -->
</div>    

            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('backend.blog.categories.update', $category->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card col-md-12">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">Category information</h4>
                                </div>
                                <!-- End Header -->
                                <div class="card-body row">
                                    @include('includes.validation-form')
                                    <div class="col-md-12 mb-2">
                                        <label for="name">Name:</label>
                                        <input type="text" name="category_name" id="name" value="{{ $category->category_name }}" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Parent:</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="selectpicker" name="parent_id" data-live-search="true">
                                                    <option value="">None</option>
                                                    @foreach ($categories as $categorie)
                                                        <option value="{{$categorie->id}}" @if($categorie->id == $category->parent_id) selected @endif data-tokens="{{$categorie->category_name}}">{{$categorie->category_name}}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                        </div>
                                        
                                          
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Slug:</label>
                                        <input type="text" name="slug" id="slug" value="{{ $category->slug }}" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="desc">Description:</label>
                                        <textarea name="category_excerpt" id="desc" rows="3" class="form-control">
                                            {{ $category->category_excerpt }}
                                        </textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-lg btn-outline-success">Save</button>
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
                                        <label for="meta_title">Meta Title:</label>
                                        <input type="text" name="meta_title" id="meta_title" value="{{ $category->meta_title }}" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="meta_description">Meta Description:</label>
                                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control">
                                            {{ $category->meta_description }}
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
            $('#meta_description').trumbowyg();
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
