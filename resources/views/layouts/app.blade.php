<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content="{{$pageTitle}}">
        <meta itemprop="description" content="{{ $pageDescription}}">

        <!-- Facebook Meta Tags -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{$pageTitle}}">
        <meta property="og:description" content="{{ $pageDescription}}">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{$pageTitle}}">
        <meta name="twitter:description" content="{{ $pageDescription}}">

        <!-- title/description -->
        <title>{{$pageTitle}}</title>
        <meta name="description" content="{{ $pageDescription}}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}"/>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/ui/trumbowyg.css" />
        @yield('css')
        <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/trumbowyg.min.js"></script>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        {{ $scripts ?? null }}

        <!-- for chat -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4556888383944808"
     crossorigin="anonymous"></script>
    </head>
    <body>

        <!-- Page Heading -->
        <x-header/>

        <!-- Page Content -->
        {{ $slot }}

        <!-- Page Footer -->
        <x-footer/>
        {{-- <x-chat-view/> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        @yield('js')


        <!-- JS Plugins Init. -->
        <script>
            function deletevarient(id) {
                $('#variantproduct-' + id).remove();
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

            function selectFileFromManagerAsset(id) {
                $('#digital_download_assets').val(id);
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

                $('#attributes').on('change', function() {
                    var attributes = $(this).val()
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('backend.products.attributes.ajaxcall') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "attributes": attributes
                        },
                        success: (data) => {
                            $('#product_attribute_values').html(data);
                        }
                    })
                })

                var getVariants = function(isDigital, productId) {
                    var values_selected = $('#product_attribute_values').val();

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('backend.products.attributes.combinations') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "values": values_selected,
                            'isDigital': isDigital,
                            product_id: productId
                        },
                        success: function(result) {
                            $('#variantsbody').html(result)
                        }
                    })
                }

                $('#generatevariants').on('click', function() {
                    getVariants($('#availabilitySwitch1').prop('checked') * 1, $(this).attr('data-product-id'));
                })

                // jQuery('#getFileManager').click(function(e) {
                //     e.preventDefault();
                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                //         }
                //     });
                //     jQuery.ajax({
                //         url: "{{ route('backend.filemanager.get_filemanager') }}",
                //         method: 'get',
                //         dataType: 'HTML',
                //         success: function(result) {
                //             $('#ajaxCalls').html(result);
                //             $('#CallFilesModal').modal('show')
                //         }
                //     });
                // });

                // jQuery('#getFileManagerModel').click(function(e) {
                //     e.preventDefault();
                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                //         }
                //     });
                //     jQuery.ajax({
                //         url: "{{ route('backend.filemanager.get_filemanager') }}",
                //         method: 'get',
                //         data: {
                //             'is_model': true
                //         },
                //         dataType: 'HTML',
                //         success: function(result) {
                //             $('#ajaxCalls').html(result);
                //             $('#CallFilesModal').modal('show')
                //         }
                //     });
                // });

                // jQuery('#getFileManagerAsset').click(function(e) {
                //     e.preventDefault();
                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                //         }
                //     });
                //     jQuery.ajax({
                //         url: "{{ route('backend.filemanager.get_filemanager') }}",
                //         method: 'get',
                //         data: {
                //             'is_asset': true
                //         },
                //         dataType: 'HTML',
                //         success: function(result) {
                //             $('#ajaxCalls').html(result);
                //             $('#CallFilesModal').modal('show')
                //         }
                //     });
                // });


                // jQuery('#getFileManagerForProducts').click(function(e) {
                //     e.preventDefault();
                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                //         }
                //     });
                //     jQuery.ajax({
                //         url: "{{ route('backend.filemanager.get_filemanager') }}",
                //         method: 'get',
                //         data: {
                //             'is_product': true,
                //             'seleted': $('#all_checks').val()
                //         },
                //         dataType: 'HTML',
                //         success: function(result) {
                //             $('#ajaxCalls').html(result);
                //             $('#CallFilesModal').modal('show')
                //         }
                //     });
                // });
            });
            $('#variant').on('change', function() {

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
        </script>
    </body>
</html>
