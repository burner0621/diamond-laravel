@extends('backend.layouts.app', ['activePage' => 'categories', 'title' => 'Edit Product Tag', 'navName' => 'productstags', 'activeButton' => 'catalogue'])

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Edit Product Tag</h1>
    </div>
    <!-- End Row -->
</div>

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('backend.products.attributes.values.update', ['id_attribute' => $attribute->id , 'id' => $value->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row justify-content-center">
                            <div class="card col-md-12">
                                <div class="card-body row">
                                    @include('includes.validation-form')
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Name:</label>
                                        <input value="{{ $value->name }}" type="text" name="name" id="name" value="" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Slug:</label>
                                        <input type="text" value="{{ $value->slug }}" name="slug" id="slug" value="" class="form-control">
                                    </div>
                                    @if($attribute->type != 0)
                                    <div class="col-md-6 mb-2">
                                        <label for="name">Value:</label>
                                            @if($attribute->type == 1)
                                            <input type="color" name="value" id="name" value="{{ $value->value }}" class="form-control">
                                            @elseif($attribute->type == 2)
                                            <div class="imagePreview img-thumbnail p-2">
                                                <img id="fileManagerPreview" src="{{ $value->image ? $value->image->getImageOptimizedFullName() : '' }}" style="width: 100%">
                                            </div>
                                            <input type="hidden" name="value" id="image_value" value="" class="form-control">
                                            <label class="btn text-primary mt-2 p-0" id="getFileManager">Select Image</label>
                                            @else($attribute->type == 0)
                                            <input type="text" name="value" id="name" value="" class="form-control">
                                            @endif
                                    </div>
                                    @else
                                        <input type="hidden" name="value" id="name" value="{{ $attribute->name }}" class="form-control">
                                    @endif

                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-lg btn-outline-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="fileManagerContainer"></div>

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

            $('.select2').select2({
                data: ["Piano", "Flute", "Guitar", "Drums", "Photography"],
                tags: true,
                maximumSelectionLength: 10,
                tokenSeparators: [',', ' '],
                placeholder: "Select or type keywords",
            })

            $('#getFileManager').click(function () {
                $.ajax({
                    url: "{{ route('backend.file.show') }}",
                    success: function (data) {
                        if (!$.trim($('#fileManagerContainer').html()))
                            $('#fileManagerContainer').html(data);

                        $('#fileManagerModal').modal('show');

                        const getSelectedItem = function (selectedId, filePath) {

                            $('#image_value').val(selectedId);
                            $('#fileManagerPreview').attr('src', filePath);
                        }

                        setSelectedItemsCB(getSelectedItem, $('#image_value').val() == '' ? [] : [$('#image_value').val()], false);
                    }
                })
            });
         })
    </script>
    @endsection
