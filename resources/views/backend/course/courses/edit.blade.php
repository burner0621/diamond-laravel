@extends('backend.layouts.app', ['activePage' => 'course', 'title' => 'Edit Course', 'navName' => 'addpost', 'activeButton' => 'blog'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit course</h1>
    </div>
    <!-- End Row -->
</div>

<form action="{{ route('backend.courses.update', $course->id) }}"
    method="post" enctype="multipart/form-data"
>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card col-md-12 mb-4">
                @if (session('success'))
                  <h4 class="text-center text-primary mt-3">
                      {{session('success')}}
                  </h4>
                @endif
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Course information</h4>
                </div>
                <!-- End Header -->

                <div class="card-body row">
                    @include('includes.validation-form')
                    <div class="mb-2">
                        <label for="txtName" class="w-100 mb-2">Name:</label>
                        <input type="text" name="name" id="txtName" value="{{ $course->name }}" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="name">Slug:</label>
                        <input type="text" value="{{ $course->slug }}" name="slug" id="slug" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="txtPrice" class="w-100 mb-2">Price:</label>
                        <input type="text" name="price" id="txtPrice" value="{{ $course->price }}" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="w-100 mb-2">Category:</label>
                        <select class="selectpicker" name="category_id" data-live-search="true" data-container="body">
                            @foreach ($arrCategories as $category)
                                <option value="{{$category->id}}" {{ $category->id == $course->category_id ? "selected" : ""}}
                                >{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>   

                    <div class="mb-2">
                        <label for="txtDescription" class="w-100 mb-2">Description:</label>
                        <textarea type="text" name="description" id="txtDescription" class="form-control editor">{{ $course->description }}</textarea>
                    </div>
                    
                    <div class="mb-2">
                        <label for="videoUrl" class="w-100 mb-2">Video Url:</label>
                        <input type="text" name="video_url" id="videoUrl" value="{{ $course->video_url }}" class="form-control">
                    </div>
                </div>
            </div>

            @include('backend.course.courses.edit.lessons')
        </div>

        <div class="col-md-4">
            <!-- Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-header-title mb-0">Thumbnail</h3>
                </div>
                <div class="card-body">
                    <div class="imagePreview pt-2 img-thumbnail">
                        <img id="fileManagerPreview" src="{{ $course->uploads->getImageOptimizedFullName(400) }}" style="width: 100%">
                    </div>
                    <label class="btn text-primary mt-2 p-0" id="getFileManager">Select thumbnail image</label>
                    <input type="hidden" value="{{ $course->uploads->id}}" id="fileManagerId" name="thumbnail">
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>

    <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
        <!-- Card -->
        <div class="card card-sm bg-dark border-dark mx-2">
            <div class="card-body">
                <div class="row justify-content-center justify-content-sm-between">
                    <div class="col">
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                    <!-- End Col -->

                <div class="col-auto">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
            </div>
        </div>
        <!-- End Card -->
    </div>
</form>

<div id="fileManagerContainer"></div>

<div id='ajaxCalls'></div>

@endsection

@section('js_content')
<script src="{{ asset('ckeditor-build/classic-ckeditor5/build/ckeditor.js') }}"></script>
<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
<script>
    createInlineEditor(".editor")
    function createInlineEditor (selector) {
        return new Promise(((resolve, reject) => {
            ClassicEditor.create(document.querySelector(selector), {
                toolbar: [
                    'heading',
                    'CKFinder',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'code',
                    'codeBlock',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo'
                ],
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },

                ckfinder: {
                    openerMethod: 'popup',
                    uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                    options: {
                        resourceType: 'Images',
                    }
                }
            }).then(data => resolve(data)).catch(error => reject(error))
                .catch( function( error ) {
                    console.error( error );
                } );

        }))
    }

</script>

<script>
$(document).ready(function() {
    //$('#txtDescription').trumbowyg();

    $(".imgAdd").click(function() {
        $(this).closest(".row").find('.imgAdd').before(
            '<div class="col-sm-2 imgUp">'
            + '<div class="imagePreview"></div>'
            + '<label class="btn btn-primary">Upload<input type="file"'
            + ' class="uploadFile img" value="Upload Photo" '
            + 'style="width:0px;height:0px;overflow:hidden;"></label>'
            + '<i class="fa fa-times del"></i></div>'
        );
    });

    $('body').on("click", "i.del", function() {
        $(this).parent().remove();
    });

    $('body').on("change", ".uploadFile", function() {
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader)
            return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image",
                    "url(" + this.result + ")");
            }
        }
    });

    $('body').on('click', '#getFileManager', function () {
        $.ajax({
            url: "{{ route('backend.file.show') }}",
            success: function (data) {
                if (!$.trim($('#fileManagerContainer').html()))
                    $('#fileManagerContainer').html(data);

                $('#fileManagerModal').modal('show');

                const getSelectedItem = function (selectedId, filePath) {

                    $('#fileManagerId').val(selectedId);
                    $('#fileManagerPreview').attr('src', filePath);
                }

                setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
            }
        })
    });
});
</script>




@stack('lesson_scripts')
@endsection
