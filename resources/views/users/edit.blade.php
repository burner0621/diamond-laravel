<x-app-layout page-title="My Informations">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="{{ asset('dropzone/css/dropzone.css') }}">
    <style>
        .dropzone {
            border-radius: 25px;
            width: 132px;
            overflow: hidden;
            padding: 4px;
            background: transparent;
        }
        .dropzone .dz-preview{
            margin: 0;
        }

        .dz-image img{
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="py-9">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="settings-side-nav">
                                <a class="nav-link w-100 d-block mb-2 {{ $tab == "account" ? "active" : "" }}" href="/user/edit?tab=account">Account</a>
                                <a class="nav-link w-100 d-block mb-2 {{ $tab == "security" ? "active" : "" }}" href="{{route('user.update.password')}}">Security</a>
                                <a class="nav-link w-100 d-block {{ $tab == "address" ? "active" : "" }}" href="/user/edit?tab=address">Address</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-8 mr-auto">
                    <form action="{{ route('user.update.'.$tab) }}" method="post">
                        @csrf
                        @method('put')

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">@include('includes.validation-form')</div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success" role="alert">{{session('success')}}</div>
                        @endif
{{--                         {{ dd($countries) }}--}}
                        <x-user-info-main :edit="true" :user="auth()->user()" :countries="$countries" :shipping="$shipping" :billing="$billing" :tab="$tab" />
                        <div class="d-flex justify-content-end mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('dropzone/js/dropzone.js') }}"></script>
<script>
Dropzone.autoDiscover = false;
var avatar = {!! json_encode(auth()->user()->uploads) !!}
var avatarDropzone;
$(document).ready(function() {
    $("#avatar_dropzone").dropzone({
            method:'post',
            url: "{{ route('seller.file.thumb') }}",
            dictDefaultMessage: "Select photos",
            paramName: "file",
            maxFilesize: 2,
            maxFiles: 1,
            clickable: true,
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            init: function () {
                avatarDropzone = this;

                if(avatar.id) {
                    var mockFile = { name: avatar.file_original_name + "." + avatar.extension, size: avatar.file_size };

                    avatarDropzone.emit("addedfile", mockFile);
                    avatarDropzone.emit("thumbnail", mockFile, `{{asset("/uploads/all")}}/${avatar.file_name}`);
                    avatarDropzone.emit("complete", mockFile);
                }
            },
            success: (file, response) => {
                var last = $("#avatar");

                last.val(response.id)
                avatar = response;
                // ONLY DO THIS IF YOU KNOW WHAT YOU'RE DOING!
            },
            removedfile: function(file) {
                $.ajax({
                    url: `/seller/file/destroy/${avatar.id}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(result) {
                        var last = $("#avatar");
                        last.val("")
                        $(file.previewElement).remove();
                    },
                    error: function(error) {
                        return false;
                    }
                });
            }
        })
});
</script>
</x-app-layout>
