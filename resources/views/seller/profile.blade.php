<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>
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
                <x-dashboard-side-bar />
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 mr-auto">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{session('success')}}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                @endif

                <form action="{{ route('seller.profile.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header">Seller Information</div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label for="business_name">Business name:</label>
                                <input type="text" name="business_name" id="business_name" value="{{ old('business_name') ?? $seller->business_name }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="whatsapp">Whatsapp:</label>
                                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') ?? $seller->whatsapp }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="slogan">Slogan:</label>
                                <input type="text" name="slogan" id="slogan" value="{{ old('slogan') ?? $seller->slogan }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="about">About:</label>
                                <input type="text" name="about" id="about" value="{{ old('about') ?? $seller->about }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="name">Default Payment Method:</label>
                                <select class="form-control" id="method" name="method" data-live-search="true" data-container="body">
                                    @foreach ($payment_methods as $method)
                                        <option value="{{$method->id}}" data-id="{{$method->id}}" {{ $method->id == $seller->default_payment_method ? "selected" : "" }}>{{$method->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-2">
                                <div class="card-header">Avatar</div>
                                <div class="card-body">
                                    <input type="hidden" name="avatar" class="avatar" id="avatar" value="{{ $seller->user->avatar }}">
                                    <div>
                                    <div class="dropzone" id="avatar_dropzone"></div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- end .row -->
    </div>
</div>

@section('js')
<script src="{{ asset('dropzone/js/dropzone.js') }}"></script>
<script>
Dropzone.autoDiscover = false;
var avatar = {!! json_encode($seller->user->uploads) !!}
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
@endsection

</x-app-layout>
