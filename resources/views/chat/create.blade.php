<x-app-layout page-title="Messages">
    <meta name="_token" content="{{csrf_token()}}"/>
    <link rel="stylesheet" href="{{ asset('dropzone/css/dropzone.css') }}">
    @section('css')
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
        <style>
            .text-overflow-1{
                display: -webkit-box !important;
                overflow: hidden;
                text-overflow: ellipsis;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                width: 100%;
            }
            .dropzone {
                border-radius: 25px;
                overflow: hidden;
                background: transparent;
                display: flex;
                border: none !important;
                width: 100%;
                flex-direction: column;
                padding: 20px 0 !important;
                min-height: unset !important;
            }

            .dropzone-items {
                margin-bottom: 10px;
            }

            .dropzone-panel {
                display: grid;
                grid-template-columns: auto max(14%, 100px) max(14%, 100px);
            }

            .dropzone .dz-preview {
                margin: 0;
            }

            .dz-image img {
                width: 100%;
            }

            .list-group > a:hover {
                background: #f0f2f5
            }

            .dropzone .dz-message {
                display: none;
            }

            .data > span {
                margin-right: 10px;
            }

            i {
                font-size: 20px;
            }

            body {
                margin-top: 20px;
            }

            .chat-online {
                color: #34ce57
            }

            .chat-offline {
                color: #e4606d
            }

            .chat-messages {
                display: flex;
                flex-direction: column;
                max-height: 60vh;
                overflow-y: scroll;
            }

            .chat-message-left,
            .chat-message-right {
                display: flex;
                flex-shrink: 0
            }

            .chat-message-left {
                margin-right: auto
            }

            .chat-message-right {
                flex-direction: row-reverse;
                margin-left: auto
            }

            .py-3 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            .px-4 {
                padding-right: 1.5rem !important;
                padding-left: 1.5rem !important;
            }

            .flex-grow-0 {
                flex-grow: 0 !important;
            }

            .border-top {
                border-top: 1px solid #dee2e6 !important;
            }

            .border-right {
                border-right: 1px solid #dee2e6 !important;
            }

            .float-right {
                float: right !important;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 0.75rem 1.25rem;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, .125);
            }

            .messages {
                padding: 30px;
            }

            .wm-200px {
                /*max-width: 200px;*/
            }

            .dropzone.dropzone-queue .dropzone-item {
                display: flex;
                align-items: center;
                margin-top: 0.75rem;
                border-radius: 0.65rem;
                padding: 0.5rem 1rem;
                background-color: #f5f8fa;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-file {
                flex-grow: 1;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-file .dropzone-filename {
                font-size: .9rem;
                font-weight: 500;
                color: #7e8299;
                text-overflow: ellipsis;
                margin-right: 0.5rem;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-file .dropzone-error {
                margin-top: 0.25rem;
                font-size: .9rem;
                font-weight: 400;
                color: #f1416c;
                text-overflow: ellipsis;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-toolbar {
                margin-left: 1rem;
                display: flex;
                flex-wrap: nowrap;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-toolbar .dropzone-cancel, .dropzone.dropzone-queue .dropzone-item .dropzone-toolbar .dropzone-delete, .dropzone.dropzone-queue .dropzone-item .dropzone-toolbar .dropzone-start {
                height: 25px;
                width: 25px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: color .2s ease, background-color .2s ease;
            }

            .dropzone.dropzone-queue .dropzone-item .dropzone-progress {
                width: 15%;
            }
        </style>
    @endsection
    <section class="messages bg-white py-8">
        @php
            function users_name($id){
                return \App\Models\User::where('id',$id)->get();
            }

             function getChatMessage($message){
                $chatMessArr = explode(":",$message);
                $isUploadFile = isset($chatMessArr[0]) && $chatMessArr[0] == "upload_ids" && isset($chatMessArr[1]);
                $file = "";
                if ($isUploadFile)
                {
                    $file = \App\Models\Upload::find($chatMessArr[1]);
                }

                return [
                        "upload_file" => $isUploadFile && $file ? $file->getFileFullPath() :'',
                        "file" => $file,
                        "link_download" => $isUploadFile && $file ?  route('download_file',base64_encode($file->id)) : "",
                ];
            }


//        @endphp

        <input type="hidden" id="user_name" value="{{auth()->user()->first_name.' '.auth()->user()->last_name}}"/>
        <input type="hidden" id="seller" value="{{$conversation_id}}"/>
        <div class="container p-0">
            <h1 class="h3 mb-3">Messages</h1>
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">

                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control my-3" placeholder="Search...">
                                </div>
                            </div>
                        </div>
                        @foreach($side_info as $info)
                            <a href="#"
                               class="list-group-item list-group-item-action border-0 filterDiscussions all unread single {{$conversation_id== $info->user_id ?"active":""}}"
                               data-toggle="list" role="tab" data-id="{{$info->user_id}}">
                                <div class="badge bg-success float-right">
                                    <span>{{$info->cnt > 0 ? $info->cnt :  0}}</span>
                                </div>
                                <div class="d-flex align-items-start">
                                    <img
                                        src="{{optional(optional(users_name($info->user_id)->first())->uploads)->getImageOptimizedFullName(100,100)}}"
                                        data-toggle="tooltip" data-placement="top" title="Janette"
                                        alt="avatar"
                                        class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                    <div class="flex-grow-1 ml-10px">
                                        {{optional(users_name($info->user_id)->first())->full_name}}
                                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                                    </div>
                                </div>
                            </a>
                            <input type="hidden" name="client_id" id="client_id"
                                   value="{{$info->user_id}}"/>
                        @endforeach
                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>

                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img
                                        src="{{optional(optional(users_name($conversation_id)->first())->uploads)->getImageOptimizedFullName(100,100)}}"
                                        data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar"
                                        class="rounded-circle mr-1" width="40" height="40">
                                </div>

                                <div class="flex-grow-1 px-2">
                                    <strong>{{optional(users_name($conversation_id)->first())->full_name}}</strong>
                                    <div class="text-muted small"><em>Active now.</em></div>

                                </div>
                                <div>
                                    <button class="btn btn-primary btn-lg mr-1 px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-phone feather-lg">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                    </button>
                                    <button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-video feather-lg">
                                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                        </svg>
                                    </button>
                                    <button class="btn btn-light border btn-lg px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal feather-lg">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative">
                            <div class="chat-messages p-4">

                                <div class="content" id="content">
                                    <div class="container" id="chat-container">
                                        <div class="col-md-12" id="chat-content">
                                            @foreach($chat_content as $content)
                                                @if($content->message != null)
                                                    @if(Auth::id() == $content->user_id)
                                                        <div class="chat-message-right pb-4">
                                                            <div class="ml-10px">
                                                                <img
                                                                    src="{{Auth::user()->uploads->getImageOptimizedFullName(100,100)}}"
                                                                    class="rounded-circle mr-1" alt="Chris Wood"
                                                                    width="40" height="40">
                                                                <div
                                                                    class="text-muted small text-nowrap mt-2">{{date('g:i a',strtotime($content->updated_at))}}</div>
                                                            </div>
                                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                                <div class="font-weight-bold mb-1">You</div>
                                                                @if(getChatMessage($content->message)["file"])
                                                                    @if(getChatMessage($content->message)["file"]->type =="image")
                                                                        <img src="{{getChatMessage($content->message)["upload_file"]}}" width="100" height="100" />
                                                                    @else
                                                                        <p  class="text-overflow-1"
                                                                            title="{{getChatMessage($content->message)["file"]->file_original_name.".".getChatMessage($content->message)["file"]->extension}}">
                                                                            {{getChatMessage($content->message)["file"]->file_original_name.".".getChatMessage($content->message)["file"]->extension}}
                                                                        </p>
                                                                    @endif
                                                                     <a   href="{{getChatMessage($content->message)["link_download"]}}" class="w-100 d-block"><i class="bi bi-download"></i></a>
                                                                @else
                                                                {{$content->message}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else

                                                        <div class="chat-message-left pb-4">
                                                            <div class="mr-10px">
                                                                <img
                                                                    src="{{optional(optional(users_name($content->user_id)->first())->uploads)->getImageOptimizedFullName(100,100)}}"
                                                                    class="rounded-circle mr-1" alt="Sharon Lessman"
                                                                    width="40" height="40">
                                                                <div
                                                                    class="text-muted small text-nowrap mt-2">{{date('g:i A',strtotime($content->updated_at))}}</div>
                                                            </div>
                                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                                <div
                                                                    class="font-weight-bold mb-1">{{users_name($content->user_id)->first()->full_name}}</div>
                                                                @if(getChatMessage($content->message)["file"])
                                                                    @if(getChatMessage($content->message)["file"]->type =="image")
                                                                        <img src="{{getChatMessage($content->message)["upload_file"]}}" width="100" height="100" />
                                                                    @else
                                                                        <p  class="text-overflow-1"
                                                                            title="{{getChatMessage($content->message)["file"]->file_original_name.".".getChatMessage($content->message)["file"]->extension}}">
                                                                            {{getChatMessage($content->message)["file"]->file_original_name.".".getChatMessage($content->message)["file"]->extension}}
                                                                        </p>
                                                                    @endif
                                                                    <a href="{{getChatMessage($content->message)["link_download"]}}" class="w-100 d-block"><i class="bi bi-download"></i></a>
                                                                @else
                                                                    {{$content->message}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach

                                            <div id="media-upload-previews">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <!--begin::Form-->
                        <!--end::Form-->
                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <div class="position-relative w-100">
                                <div class="input-group">
                                    <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_2">
                                        <!--begin::Controls-->
                                        <div class="dropzone-items wm-200px">
                                            <div class="dropzone-item" style="display:none">
                                                <!--begin::File-->
                                                <div class="dropzone-file">
                                                    <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                        <span data-dz-name>some_image_file_name.jpg</span>
                                                        <strong>(<span data-dz-size>340kb</span>)</strong>
                                                    </div>

                                                    <div class="dropzone-error" data-dz-errormessage></div>
                                                </div>
                                                <!--end::File-->

                                                <!--begin::Progress-->
                                                <div class="dropzone-progress">
                                                    <div class="progress">
                                                        <div
                                                            class="progress-bar bg-primary"
                                                            role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->

                                                <!--begin::Toolbar-->
                                                <div class="dropzone-toolbar">
                                                    <span class="dropzone-start"><i class="bi d-none bi-play-fill fs-3"></i></span>
                                                    <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
                                                    <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                                </div>
                                                <!--end::Toolbar-->
                                            </div>
                                        </div>
                                        <div class="dropzone-panel mb-lg-0 mb-2">
                                            <input form="uploadFileForm" type="text" id="chat_input"
                                                   class="form-control"
                                                   autocomplete="off"
                                                   placeholder="Start typing for reply...">
                                            <button class="btn btn-primary dropzone-upload mx-2">Send</button>

                                            <a class="dropzone-select btn btn-sm  btn-dark"><i class="fa fa-link"
                                                                                                      aria-hidden="true"></i></a>
                                            <a class="dropzone-upload btn btn-sm btn-light-primary me-2 d-none">Upload All</a>
                                            <a class="dropzone-remove-all btn btn-sm btn-light-primary d-none">Remove All</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">

            @section('js')
                <script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
                <script src="{{ asset('dropzone/js/dropzone.js') }}"></script>
                <script>
                    Dropzone.autoDiscover = false;

                    // set the dropzone container id
                    const id = "#kt_dropzonejs_example_2";
                    const dropzone = document.querySelector(id);

                    // set the preview element template
                    var previewNode = dropzone.querySelector(".dropzone-item");
                    previewNode.id = "";
                    var previewTemplate = previewNode.parentNode.innerHTML;
                    previewNode.parentNode.removeChild(previewNode);

                    var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
                        method: 'post',
                        url: "{{ route('api_upload') }}",
                        dictDefaultMessage: "",
                        paramName: "file",
                        maxFiles: 13,
                        parallelUploads: 20,
                        maxFilesize: 256, // Max filesize'
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        previewTemplate: previewTemplate,
                        autoQueue: false, // Make sure the files aren't queued until manually added
                        previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                        clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
                    });

                    myDropzone.on("addedfile", function (file) {
                        // Hookup the start button
                        file.previewElement.querySelector(id + " .dropzone-start").onclick = function () { myDropzone.enqueueFile(file); };
                        const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
                        dropzoneItems.forEach(dropzoneItem => {
                            dropzoneItem.style.display = '';
                        });
                        dropzone.querySelector('.dropzone-upload').style.display = "inline-block";
                        dropzone.querySelector('.dropzone-remove-all').style.display = "inline-block";
                    });

                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function (progress) {
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.width = progress + "%";
                        });
                    });

                    myDropzone.on("sending", function (file) {
                        // Show the total progress bar when upload starts
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.opacity = "1";
                        });
                        // And disable the start button
                        file.previewElement.querySelector(id + " .dropzone-start").setAttribute("disabled", "disabled");
                    });

                    // Hide the total progress bar when nothing's uploading anymore
                    myDropzone.on("complete", function (progress) {
                        const progressBars = dropzone.querySelectorAll('.dz-complete');

                        setTimeout(function () {
                            progressBars.forEach(progressBar => {
                                progressBar.querySelector('.progress-bar').style.opacity = "1";
                                progressBar.querySelector('.progress').style.opacity = "1";
                                progressBar.querySelector('.dropzone-start').style.opacity = "100";
                            });
                        }, 300);
                    });

                    // Setup the buttons for all transfers
                    dropzone.querySelector(".dropzone-upload").addEventListener('click', function () {
                        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
                    });

                    // Setup the button for remove all files
                    dropzone.querySelector(".dropzone-remove-all").addEventListener('click', function () {
                        dropzone.querySelector('.dropzone-upload').style.display = "block";
                        dropzone.querySelector('.dropzone-remove-all').style.display = "none";
                        myDropzone.removeAllFiles(true);
                    });

                    // On all files completed upload
                    myDropzone.on("queuecomplete", function (progress) {
                        const uploadIcons = dropzone.querySelectorAll('.dropzone-upload');
                        uploadIcons.forEach(uploadIcon => {
                            uploadIcon.style.display = "block";
                        });
                    });

                    // On all files removed
                    myDropzone.on("removedfile", function (file) {
                        if (myDropzone.files.length < 1) {
                            dropzone.querySelector('.dropzone-upload').style.display = "block";
                            dropzone.querySelector('.dropzone-remove-all').style.display = "none";
                        }
                    });


                    myDropzone.on("success", async function (file, responseText) {
                        let message = getMsgBy(`upload_ids:${responseText.id}`);
                        let res = await sendMessage(message)
                        if(res.result){
                            renderMessageAfterUploadFile(res)
                        }
                    })


                    function renderMessageAfterUploadFile(res)
                    {

                        if(res.upload_file)
                        {
                            let user = res.user;
                            let file = res.file;
                            let msg = ` <div class="chat-message-right pb-4">
                                    <div class="ml-10px">
                                        <img src="${userImageUrl}"
                                             class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                        <div class="text-muted small text-nowrap mt-2">${getDateFormat()}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                  `
                            if (file.type == "image")
                            {
                                msg+=`   <img src="${res.upload_file}" width="100" height="100" />`;
                            }else{
                                msg+= ` <p  class="text-overflow-1"
                        title="${file['file_original_name']}.${file['extension']}">
                    ${file['file_original_name']}.${file['extension']}</p>
                `
                            }
                            msg+=`
                         <a href="${res.link_download}"class="w-100 d-block"><i class="bi bi-download"></i></a>
                         </div>
                                </div>`;
                            $('#chat-content').append(msg); // Append the new message received
                            $(".chat-messages").animate({scrollTop: $('.chat-messages').prop("scrollHeight")}, 10); // Scroll the chat output div

                        }
                    }

                    // myDropzone.on("removedfile",function(file) {
                    //     $.ajax({
                    //         url: `/seller/file/destroy/${avatar.id}`,
                    //         type: 'POST',
                    //         headers: {
                    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    //         },
                    //         success: function(result) {
                    //             var last = $("#avatar");
                    //             last.val("")
                    //             $(file.previewElement).remove();
                    //         },
                    //         error: function(error) {
                    //             return false;
                    //         }
                    //     });
                    // })

                </script>
                <script type="text/javascript">

                    const userImageUrl = @json(Auth::user()->uploads->getImageOptimizedFullName(100,100));

                    const ably = new Ably.Realtime.Promise("{{env('ABLY_KEY')}}");
                    var client_id = document.getElementById('seller').value;
                    // const ably = new Ably.Realtime.Promise('n-4_Uw.JXK4Fg:Q68j6Dp4ZoeVLbo--o3Mane1kNfcpVckpO-xp-CAGZ4');
                    let ablyConnected = false;
                    let channel;
                    ably.connection.once('connected').then(res => {
                        console.log('ably connected');
                        ablyConnected = true;
                        channel = ably.channels.get('chat-channel');
                        channel.subscribe('chat-{{auth()->id()}}', (msg) => {
                            handleReceivedMessage(msg);
                        })
                    })

                    $('document').ready(function () {

                        $(".chat-messages").animate({scrollTop: $('.chat-messages').prop("scrollHeight")}, 10); // Scroll the chat output div

                        $('.filterDiscussions').click(function () {

                            client_id = $(this).attr('data-id');
                            $(location).attr('href', `{{env('APP_URL')}}/chat/${client_id}`);
                            // windows.location.href(`http://localhost/jewelrycg/public/chat/${client_id}`);
                            // $.ajax({
                            //     type: 'GET',
                            //     url: "{{ route('chat.clientId') }}",
                            //     data: {
                            //         "client_id": $(this).attr('data-id')
                            //     },
                            //     dataType: "json",
                            //     success: (result) => {
                            //          const contentTab = $("div#content #chat-content");
                            //          contentTab.html("");
                            //         $.each(result.chat_content, function(key, value){
                            //              if(value.message !=null){
                            //                 if($('#user_name').val() == value.name){
                            //                     var message = '';
                            //                     message += '<div class="message me" <img class="avatar-md" src="{{asset('assets/img/avatar.png')}}" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">'+ '<div class="text-main">' + '<div class="text-group me">' + '<div class="text me">' + '<p>' + value.message + '</p></div></div>' + '<span>' + value.updated_at + '</span></div></div>';
                            //                     contentTab.append(message);
                            //                 }else{
                            //                     var message = '';
                            //                     message +='<div class="message"> <img class="avatar-md" src="{{asset('assets/img/avatar.png')}}" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">'+ '<div class="text-main">' + '<div class="text-group">' + '<div class="text">' + '<p>' + value.message + '</p></div></div>' + '<span>' + value.updated_at + '</span></div></div>';
                            //                     contentTab.append(message);
                            //                 }
                            //              }
                            //         });

                            //     },
                            //     error: (resp) => {
                            //         var result = resp.responseJSON;
                            //         if (result.errors && result.message) {
                            //             alert(result.message);
                            //             return;
                            //         }
                            //     }
                            // });
                        })
                    });

                    function formatAMPM(date) {
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'pm' : 'am';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // the hour '0' should be '12'
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        var strTime = hours + ':' + minutes + ' ' + ampm;
                        return strTime;
                    }

                    function getDateFormat() {
                        return formatAMPM(new Date);
                    }

                    function getMsgBy(message) {
                        return JSON.stringify({
                            'type': 'chat',
                            'user_id': '{{auth()->id()}}',
                            'user_name': '{{auth()->user()->first_name.' '.auth()->user()->last_name}}',
                            'chat_msg': message,
                            'conversation_id': client_id,
                        })
                    }

                    $(document).on('click', '.dropzone-upload', function () {
                        senChatMessageWith($('#chat_input').val())
                    })
                    // Bind onkeyup event after connection
                    $('#chat_input').on('keyup', function (e) {
                        if (e.keyCode === 13 && !e.shiftKey) {
                            let chat_msg = $(this).val();
                            senChatMessageWith(chat_msg);
                            dropzone.querySelector(".dropzone-upload").click();
                        }
                    });

                    function senChatMessageWith(message) {
                        if(message)
                        {
                            let msg = getMsgBy(message);
                            sendMessage(msg);
                            let content = `
                                    <div class="chat-message-right pb-4">
                                    <div class="ml-10px">
                                        <img src="${userImageUrl}"
                                             class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                        <div class="text-muted small text-nowrap mt-2">${getDateFormat()}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                        ${message}
                                    </div>
                                </div>
`;
                            $('#chat-content').append(content);
                            $('#chat_input').val('');
                            $(".chat-messages").animate({scrollTop: $('.chat-messages').prop("scrollHeight")}, 10); // Scroll the chat output div

                        }
                    }

                    function sendMessage(msg) {
                        if (channel) {
                            console.log(channel);
                            console.log('clientid: ', client_id);
                            channel.publish('chat-' + client_id, msg);

                            return $.ajax({
                                type: 'POST',
                                url: "{{ route('chat.message_log') }}",
                                data: {
                                    "data": JSON.parse(msg),
                                    "_token": '{{ csrf_token() }}'
                                },
                                dataType: "json",
                            }).then(res => {
                                return res
                            })
                                .catch((resp) => {
                                    var result = resp.responseJSON;
                                    if (result.errors && result.message) {
                                        alert(result.message);
                                        return;
                                    }
                                });
                        }
                    }

                    function getChatFileInformation(file_id, user_id, conversation_id) {
                          return $.ajax({
                            type: 'POST',
                            url: "{{ route('chat.information') }}",
                            data: {
                                file_id,
                                user_id,
                                conversation_id,
                                "_token": '{{ csrf_token() }}'
                            },
                            dataType: "json",
                        }).then(res => {
                            return res
                        })
                            .catch((resp) => {
                                var result = resp.responseJSON;
                                if (result.errors && result.message) {
                                    alert(result.message);
                                    return;
                                }
                            });
                    }

                    async function handleReceivedMessage(msg) {
                        const data = JSON.parse(msg.data);
                        let msgArr = data.chat_msg.split(':');
                        if (data.conversation_id == {{auth()->id()}} && data.user_id == {{$conversation_id}}) {
                            let isFile = msgArr?.[0] == "upload_ids" && msgArr?.[1];

                            switch (data.type) {
                                case 'chat':
                                    let chatFileInfo = await getChatFileInformation( msgArr?.[1], data.user_id, data.conversation_id)

                                    let conversation = chatFileInfo.conversation;
                                    let user = chatFileInfo.user;
                                    let msg = `<div class="chat-message-left pb-4">
                                <div class="mr-10px">
                                    <img src="${user.image_url}"
                                         class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                        <div class="text-muted small text-nowrap mt-2">${getDateFormat()}</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                    <div class="font-weight-bold mb-1">${user.full_name}</div>
                        `;
                                    if(chatFileInfo.file)
                                    {
                                        let file = chatFileInfo.file;
                                        if (file.type == "image")
                                        {
                                            msg+=`   <img src="${chatFileInfo.path}" width="100" height="100" />`;
                                        }else{
                                            msg+= ` <p  class="text-overflow-1"
                                                title="${file['file_original_name']}.${file['extension']}">
                                            ${file['file_original_name']}.${file['extension']}</p>
                                            `
                                        }
                                        msg+=`    <a href="${chatFileInfo.link_download}" class="w-100 d-block"><i class="bi bi-download"></i></a>`;

                                    }else{
                                        msg +=`${data.chat_msg}`;
                                    }
                                    msg += `  </div>
                                        </div>`

                                    $('#chat-content').append(msg); // Append the new message received
                                    $(".chat-messages").animate({scrollTop: $('.chat-messages').prop("scrollHeight")}, 10); // Scroll the chat output div
                                    break;
                                case 'socket':
                                    $('#chat-content').append(data.msg);
                                    console.log("Received " + data.msg);
                                    break;
                            }
                        }
                    }
                </script>
        </div>
    </section>


    @endsection
</x-app-layout>

