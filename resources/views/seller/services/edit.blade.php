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
            <div class="page-header">
                <div class="row align-items-end">
                    <h1 class="page-header-title">Edit service</h1>
                </div>
                <!-- End Row -->
            </div>
                <style>
                    .imagePreviewUpdate {
                        width: 100%;
                        height: 180px;
                        background-position: center center;
                        background: url({{ $service->cover_image }});
                        background-color: #fff;
                        background-size: cover;
                        background-repeat: no-repeat;
                        display: inline-block;
                        box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
                    }
                </style>
                <form action="{{ route('seller.services.update', $service->id) }}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            @csrf
                            @method('PUT')
                            <div class="card col-md-12 mb-2">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">service information</h4>
                                </div>
                                <!-- End Header -->
                                <div class="card-body row">
                                    @include('includes.validation-form')

                                    <div class="col-md-12 mb-2">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" value="{{ $service->name }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="name">Slug:</label>
                                        <input type="text" name="slug" id="slug" value="{{ $service->slug }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="desc">service:</label>
                                        <textarea name="service" id="desc" rows="3" class="form-control">
                                            {{ $service->service }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-header-title mb-0">Status</h3>
                                    <small class="text-muted">Published: 2 days ago</small>
                                </div>
                                <div class="card-body">
                                    {{ date('F d, Y, h:i:s A', strtotime($service->created_at)) }}
                                    <br />
                                    <br />
                                    Author: {{ $service->postauthor->first_name . " " . $service->postauthor->last_name }}
                                </div>
                            </div>
                            <!-- End Card -->

                            <!-- Card -->
                            <div class="card mb-3 mb-4">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title mb-0">Organization</h4>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body">
                                    <div class="col-12 mb-4">
                                    <label class="mb-2" for="">Status</label>
                                        <select class="selectpicker w-100" name="status">
                                            <option value="1" @if($service->status == 1) selected @endif selected>Published</option>
                                            <option value="2" @if($service->status == 2) selected @endif>Draft</option>
                                            <option value="3" @if($service->status == 3) selected @endif>Pending Review</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="category" class="mb-2 w-100">Category:</label>
                                        <select multiple class="selectpicker" name="categories[]" data-live-search="true" data-container="body">
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}"
                                                @if ($service->categories->contains('id_category', $categorie->id)) selected @endif
                                                data-tokens="{{ $categorie->category_name }}">
                                                {{ $categorie->category_name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="name" class="mb-2">Tags:</label>
                                        <select name="tags[]" id="tags" value="" class="form-control select2" multiple="multiple" style="width: 100%;">
                                            @foreach ($tags as $tag)
                                                <option @if ($service->tags->contains('id_tag', $tag->id)) selected @endif
                                                    value='{{ $tag->id }}'> {{ $tag->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Card -->
                            <!-- Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-header-title mb-0">Featured Image</h3>
                                </div>
                                <div class="card-body">
                                    <div class="imagePreview img-thumbnail p-2">
                                        <img id="fileManagerPreview" src="{{ $service->uploads->getImageOptimizedFullName(400) }}" style="width: 100%">
                                    </div>
                                    <label class="btn text-primary mt-2 p-0" id="getFileManager">Select featured image</label>
                                    <input type="hidden" value="{{ $service->uploads->id}}" id="fileManagerId" name="thumbnail">
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
                                <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                                <!-- End Col -->

                                <div class="col-auto">
                                <div class="d-flex gap-3">
                                    <button type="button" class="btn btn-light">Unpublish</button>
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

                <div id='ajaxCalls'>
                </div>

            @section('js_content')
                <script>
                    $(document).ready(function() {
                        $('#desc').trumbowyg();
                        // $('#meta_description').trumbowyg();
                    })
                    $(".imgAdd").click(function() {
                        $(this).closest(".row").find('.imgAdd').before(
                            '<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>'
                        );
                    });
                    $(document).on("click", "i.del", function() {
                        $(this).parent().remove();
                    });
                    $(function() {
                        $(document).on("change", ".uploadFile", function() {
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
                        $('.select2').select2({

                            tags: true,
                            maximumSelectionLength: 100,
                            tokenSeparators: [','],
                            placeholder: "Select or type keywords",
                        })


                        $('#getFileManager').click(function () {
                            $.ajax({
                                url: "{{ route('file.show') }}",
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
            @endsection
        </div>
    </div>
</x-app-layout>
