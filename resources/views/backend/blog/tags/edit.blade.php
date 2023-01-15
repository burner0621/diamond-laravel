@extends('backend.layouts.app', ['activePage' => 'posts', 'title' => 'Edit Tags', 'navName' => 'blogtags', 'activeButton' => 'catalogue'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit Tag</h1>
    </div>
    <!-- End Row -->
</div>  

            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('backend.blog.tags.update', $tag->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card col-md-12">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">Tag information</h4>
                                </div>
                                <!-- End Header -->
                                <div class="card-body row">
                                    @include('includes.validation-form')
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Name:</label>
                                        <input value="{{ $tag->name }}" type="text" name="name" id="name" value="" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Slug:</label>
                                        <input type="text" value="{{ $tag->slug }}" name="slug" id="slug" value="" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="desc">Description:</label>
                                        <textarea name="description" value="{{ $tag->description }}" id="desc" rows="3" class="form-control">{{ $tag->description }}</textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-lg btn-outline-success">Update</button>
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
                                        <input value="{{ $tag->meta_title }}" type="text" name="meta_title" id="meta_title" value="" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_description">Meta Description:</label>
                                        <textarea name="meta_description" value="{{ $tag->meta_description }}" id="meta_description" rows="3" class="form-control">{{ $tag->meta_description }}</textarea>
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

            $('.select2').select2({
            data: ["Piano", "Flute", "Guitar", "Drums", "Photography"],
            tags: true,
            maximumSelectionLength: 10,
            tokenSeparators: [',', ' '],
            placeholder: "Select or type keywords",
            })
         })
    </script> 
    @endsection
