<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>{{ $title }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}" data-hs-appearance="default"as="style">

    <link rel="stylesheet" href="{{ asset('assets/css/backend/theme.min.css') }}" data-hs-appearance="default"as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/backend/custom.css') }}" as="style">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/ui/trumbowyg.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />

</head>

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">

    @include('backend.layouts.navbars.navbar')
    @include('backend.layouts.navbars.sidebar')

    <main id="content" role="main" class="main">
        <!-- Content -->
        <div class="content container-fluid">
            @yield('content')
        </div>
        @include('backend.layouts.footer.nav')
    </main>

    @stack('js')
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/hs-form-search/dist/hs-form-search.min.js') }}"></script>
    <script src="{{ asset('assets/js/hs.theme-appearance.js') }}"></script>

    <!-- JS Front -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/trumbowyg.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>

        function deletevarient(id){
            $('#variantproduct-'+id).remove();
        }
        function selectFileFromManager(id, preview) {
            $('#fileManagerPreview').attr('src', preview);
            $('#fileManagerId').val(id);
            $('#CallFilesModal').modal('hide')
            return false;
        }

        function selectFileFromManagerModel(id) {
            $('#fileManagerModelId').val(id);
            $('#CallFilesModal').modal('hide')
        }

        function uploadAjax(is_model, is_product) {
            var files = $("#prepare_images").get(0).files[0];
            var formData = new FormData()
            formData.append('file', files);
            formData.append("_token", "{{ csrf_token() }}")
            formData.append("is_model", is_model)
            formData.append("is_product", is_product)
        
                 jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('backend.filemanager.ajaxupload') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#modelmanagerAppend').html(data);
                        $('#media-tab').trigger('click')
                    }
                    }) 
                    
            }

            function uploadPrepareAjax(is_model, is_product) {
                $("#prepare_images").trigger('click');
            }

            function productImageDiv(id, preview) {
                var div = '<div id="fileappend-' + id + '" class="col-6 col-sm-4 col-md-3 mb-3 mb-lg-5">' +
                    '<div class="card card-sm">' +
                    '<img class="card-img-top" src="' + preview + '" alt="Image Description">' +

                    '<div class="card-body">' +
                    '<div class="row col-divider text-center">' +
                    '<div class="col">' +
                    '<a class="text-body" href="./assets/img/1920x1080/img3.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-fslightbox="gallery" data-bs-original-title="View">' +
                    '<i class="bi-eye"></i>' +
                    '</a>' +
                    '</div>' +


                    '<div class="col">' +
                    '<a onclick="removepreviewappended(' + id +
                    ')" class="text-danger" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">' +
                    '<i class="bi-trash"></i>' +
                    '</a>' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '</div>' +
                    '</div>';
                return div;
            }

            jQuery(document).ready(function() {
                $(document).on("click", ".modal-body li a", function() {
                    tab = $(this).attr("href");
                    $(".modal-body .tab-content div").each(function() {
                        $(this).removeClass("active");
                    });
                    $(".modal-body .tab-content " + tab).addClass("active");
                });

                $('#attributes').on('change', function(){
                    var attributes = $(this).val()
                    $.ajax({
                    type: 'POST',
                    url: "{{ route('backend.products.attributes.ajaxcall') }}",
                    data: {
                        "_token"    : "{{ csrf_token() }}",
                        "attributes": attributes
                    },
                    success: (data) => {
                       $('#product_attribute_values').html(data);
                    }
                    }) 
                    
                })

                $('#generatevariants').on('click', function(){
                    var values_selected = $('#product_attribute_values').val()
                    $.ajax({
                    type: 'POST',
                    url: "{{ route('backend.products.attributes.combinations') }}",
                    data: {
                        "_token"    : "{{ csrf_token() }}",
                        "values": values_selected
                    },
                    success: function(result) {
                        $('#variantsbody').html(result)
                    }
                })
            })
                jQuery('#getFileManager').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ route('backend.filemanager.get_filemanager') }}",
                        method: 'get',
                        dataType: 'HTML',
                        success: function(result) {
                            $('#ajaxCalls').html(result);
                            $('#CallFilesModal').modal('show')
                        }
                    });
                });

                jQuery('#getFileManagerModel').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ route('backend.filemanager.get_filemanager') }}",
                        method: 'get',
                        data: {
                            'is_model': true
                        },
                        dataType: 'HTML',
                        success: function(result) {
                            $('#ajaxCalls').html(result);
                            $('#CallFilesModal').modal('show')
                        }
                    });
                });

                jQuery('#getFileManagerForProducts').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ route('backend.filemanager.get_filemanager') }}",
                        method: 'get',
                        data: {
                            'is_product': true,
                            'seleted': $('#all_checks').val()
                        },
                        dataType: 'HTML',
                        success: function(result) {
                            $('#ajaxCalls').html(result);
                            $('#CallFilesModal').modal('show')
                        }
                    });
                });
            });
            $('#variant').on('change', function(){
             
                    jQuery.ajax({
                        url: "{{ route('backend.products.attributes.getvalues') }}",
                        method: 'post',
                        data: {
                            'id_attribute': $(this).val(),
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'HTML',
                        success: function(result) {
                            $('#variantsbody').html(result)
                        }
                    });
            })
            (function() {
                // INITIALIZATION OF NAVBAR VERTICAL ASIDE
                // =======================================================
                new HSSideNav('.js-navbar-vertical-aside').init()


                // INITIALIZATION OF FORM SEARCH
                // =======================================================
                new HSFormSearch('.js-form-search')


                // INITIALIZATION OF BOOTSTRAP DROPDOWN
                // =======================================================
                HSBsDropdown.init()
            })()
    </script>

    @yield('js_content')
</body>

</html>
