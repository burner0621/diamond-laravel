<x-app-layout :page-title="'Order #' . $order->order_id">
    <meta name="_token" content="{{csrf_token()}}"/>
    <link rel="stylesheet" href="{{ asset('dropzone/css/dropzone.css') }}">
    <style>
        label.required::after {
            content: "*";
            color: red;
        }

        .select-option {
            padding: 0.375rem 0.75rem 0.375rem 0.75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin-bottom: 0.5rem;
            cursor: pointer;
        }

        .select-option.selected {
            border-color: #198754;
        }

        .was-validated .required .invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url(data:image/svg+xml,%3csvg xmlns= 'http://www.w3.org/2000/svg' viewBox= '0 0 12 12' width= '12' height= '12' fill= 'none' stroke= '%23dc3545' %3e%3ccircle cx= '6' cy= '6' r= '4.5' /%3e%3cpath stroke-linejoin= 'round' d= 'M5.8 3.6h.4L6 6.5z' /%3e%3ccircle cx= '6' cy= '8.2' r= '.6' fill= '%23dc3545' stroke= 'none' /%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .was-validated .required .valid {
            border-color: #198754;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url(data:image/svg+xml,%3csvg xmlns= 'http://www.w3.org/2000/svg' viewBox= '0 0 8 8' %3e%3cpath fill= '%23198754' d= 'M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z' /%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
    <div class="container">
        <div class="col-lg-11 col-md-10 py-9 mx-auto checkout-wrap">
            <div class="row">
                <div class="col-lg-9">
                    @include('includes.validation-form')
                    @if (session('success'))
                        <!--<div class="alert alert-success" role="alert">{{session('success')}}</div>-->
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-body">
                            @if ($order->status == 0)
                                <h4 class="fw-700">Order Received</h4>
                                <p class="mb-0">Please submit the requirements in order to start job.</p>
                            @else
                                <h4 class="fw-700">Order Started</h4>
                                <p class="mb-0">You sent all the information needed and your order has started.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="timeline-item pb-3 mb-3 border-bottom">
                                <i class="bi bi-clipboard-check p-1"></i>
                                <span
                                    class="">You placed the order {{ date('F d, Y h:i A', strtotime($order->created_at)) }}</span>
                            </div>
                            @if ($order->status != 0)
                                @if (count($requirements) > 0)
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span
                                            class="">You sent the requirements {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                    </div>
                                @endif

                                @if (count($answers) > 0)
                                    <div class="card">
                                        <div class="card-header fw-700">Requirements</div>
                                        <div class="card-body">
                                            @foreach ($answers as $answer)
                                                <div class="col">
                                                    <h4>{{ $answer->requirement->delivery }}</h4>

                                                    @if ($answer->requirement->type == 0)
                                                        <p>{{ $answer->answer }}</p>

                                                    @elseif ($answer->requirement->type == 1)
                                                        <ul>
                                                            @foreach ($answer->attaches as $attach)
                                                                <li>
                                                                    <a href="/uploads/all/{{ $attach->file_name }}"
                                                                       download>
                                                                        {{ $attach->file_original_name . "." . $attach->extension }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                    @elseif ($answer->requirement->type == 2)
                                                        <p>{{$answer->answer}}</p>
                                                    @else
                                                        <ul>
                                                            @foreach ($answer->answers as $answer)
                                                                <li><p>{{ $answer }}</p></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($order->status != 0)
                                <div class="timeline-item pb-3 mb-3 border-bottom">
                                    <i class="bi bi-clipboard-check p-1"></i>
                                    <span
                                        class="">The order started {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                </div>
                                <div class="timeline-item pb-3 mb-3 border-bottom">
                                    <i class="bi bi-clipboard-check p-1"></i>
                                    <span
                                        class="">Your delivery date was updated to {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                </div>

                                @if (count($deliveries) > 0)
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span class=""><b>{{ $seller->first_name . " " . $seller->last_name }}</b> delivered the order {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                    </div>
                                @endif
                            @endif

                            @foreach ($deliveries as $key => $delivery)
                                <div class="card">
                                    <div class="card-header">Deliver #{{$key + 1}}</div>
                                    <div class="card-body">
                                        <p>{!! $delivery->message !!}</p>
                                        <ul>
                                            @foreach ($delivery->attaches as $attach)
                                                <li>
                                                    <a href="/uploads/all/{{ $attach->file_name }}" download>
                                                        {{ $attach->file_original_name . "." . $attach->extension }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                @if (!$delivery->revision && $order->status == 4)
                                    <div class="card">
                                        <div class="card-header">
                                            You received delivery
                                            from {{$seller->first_name . " " . $seller->last_name}}<br>
                                            Are you pleased with the delivery and ready to approve it?
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <form action="{{ route('services.order_complete') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    <div class="row">
                                                        <div class="col-auto mb-2">
                                                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseSubmit" role="button" aria-expanded="false" aria-controls="collapseSubmit">I approve delivery</a>
                                                        </div>
                                                        <div class="col-auto">
                                                            @if ($order->revisions)
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#messageModal">I'm not ready yet</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="collapse" id="collapseSubmit">
                                                        <div class="card card-body mt-3">
                                                            <p class="text-danger">Are you sure you approve the delivery?</p>

                                                            <div class="row">
                                                                <div class="col-auto mb-2">
                                                                    <button class="btn btn-primary" type="submit">Yes, I approve delivery</button>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubmit" aria-expanded="false" aria-controls="collapse Submit">Not Yet</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="messageModal" data-bs-backdrop="static"
                                         data-bs-keyboard="false" tabindex="-1" aria-labelledby="messageModalLabel"
                                         aria-hidden="true">
                                        <form action="{{ route('services.order_revision') }}" method="POST">
                                            @csrf
                                            <div class="card col-md-12 mb-4">
                                                <div class="card-header">
                                                    What revisions would you
                                                    like {{$seller->first_name . " " . $seller->last_name}} to make?
                                                </div>
                                                <!-- End Header -->
                                                <div class="card-body">
                                                    <input type="hidden" name="order_id" id="order_id"
                                                           value="{{ $order->id }}">
                                                    <input type="hidden" name="delivery_id" id="delivery_id"
                                                           value="{{ $delivery->id }}">
                                                    <div class="mb-2">
                                                        <label for="message" class="w-100 mb-2">Message</label>
                                                        <textarea name="message" id="message" rows="6"
                                                                  class="form-control">{{ old('message') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Submit Message</button>
                                        </form>
                                    </div>
                                @elseif ($order->status != 5)
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span
                                            class="">You requested a revision on this delivery {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">Revision #{{$key + 1}}</div>
                                        <div class="card-body">
                                            <p>{!! $delivery->revision->message !!}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if ($order->status == 5)
                                <div class="timeline-item pb-3 mb-3 border-bottom">
                                    <i class="bi bi-clipboard-check p-1"></i>
                                    <span class="">You approved delivery at {{ date('F d, Y h:i A', strtotime($order->updated_at)) }}. Order completed</span>
                                </div>
                                @if (count($order->review))
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span
                                            class="">You left a review to service at {{ date('F d, Y h:i A', strtotime($order->review[0]->created_at)) }}</span>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Your Review</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="rate pb-3">
                                                @for ($i = 5; $i > 0; $i--)
                                                    <input
                                                        type="radio" id="star{!! $i !!}" class="rate" name="rating1"
                                                        value="{!! $i !!}"
                                                        {{ $order->review[0]->rating == $i ? "checked" : "" }}
                                                        disabled
                                                    />
                                                    <label for="star{!! $i !!}">{{ $i }}</label>
                                                @endfor
                                            </div>
                                            <div style="clear: left;">
                                                {{ $order->review[0]->review }}
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($order->review) == 2)
                                        <div class="timeline-item pb-3 mb-3 border-bottom">
                                            <i class="bi bi-clipboard-check p-1"></i>
                                            <span class="">{{$order->service->postauthor->first_name . " " . $order->service->postauthor->last_name}} sent review to you at {{ date('F d, Y h:i A', strtotime($order->review[1]->created_at)) }}</span>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{$order->service->postauthor->first_name . " " . $order->service->postauthor->last_name}}
                                                    's Review</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="rate pb-3">
                                                    @for ($i = 5; $i > 0; $i--)
                                                        <input
                                                            type="radio" id="star{!! $i !!}" class="rate"
                                                            name="rating2" value="{!! $i !!}"
                                                            {{ $order->review[1]->rating == $i ? "checked" : "" }}
                                                            disabled
                                                        />
                                                        <label for="star{!! $i !!}">{{ $i }}</label>
                                                    @endfor
                                                </div>
                                                <div style="clear: left;">
                                                    {{ $order->review[1]->review }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('services.review', $order->order_id) }}">Leave a review</a>
                                @endif
                            @endif

                            @if(Session::get('message') != null)
                                <div class="alert alert-success">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            @if (count($requirements) > 0 && $order->status == 0)
                                <div class="card">
                                    <div class="card-header">Submit Requirements</div>
                                    <div class="card-body">
                                        <form id="question-form" class="needs-validation"
                                              action="{{ route('services.answer') }}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            @foreach ($requirements as $requirement)
                                                <div class="mb-3">
                                                    <label
                                                        class="fs-4 mb-2 {{ $requirement->required ? "required" : "" }}"
                                                        for="answer-{{$requirement->id}}">- {{ $requirement->question }}</label>
                                                    @if($requirement->type == 0)
                                                        <div class="form-group">
                                                            <textarea type="text" class="form-control"
                                                                      id="answer-{{$requirement->id}}"
                                                                      data-id="{{$requirement->id}}" name="answer[]"
                                                                      placeholder="Type question here" {{ $requirement->required ? "required" : "" }}></textarea>
                                                        </div>
                                                    @elseif($requirement->type == 1)
                                                        <div
                                                            class="form-group {{ $requirement->required ? "required" : "" }}">
                                                            <input class="answer" type="hidden"
                                                                   id="answer-{{$requirement->id}}"
                                                                   data-id="{{$requirement->id}}" name="answer[]">
                                                            <div
                                                                class="form-control invalid attach-dropzone dropzone attach-{{$requirement->id}}"
                                                                data-id="{{$requirement->id}}"></div>
                                                        </div>
                                                    @elseif($requirement->type == 2)
                                                        <div
                                                            class="form-group {{ $requirement->required ? "required" : "" }}">
                                                            <input class="answer" type="hidden"
                                                                   id="answer-{{$requirement->id}}"
                                                                   data-id="{{$requirement->id}}" name="answer[]">
                                                            @foreach($requirement->choices as $key => $choice)
                                                                <div
                                                                    class="select-option form-row-between invalid single">{{$choice->choice}}</div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div
                                                            class="form-group {{ $requirement->required ? "required" : "" }}">
                                                            <input class="answer" type="hidden"
                                                                   id="answer-{{$requirement->id}}"
                                                                   data-id="{{$requirement->id}}" name="answer[]">
                                                            @foreach($requirement->choices as $key => $choice)
                                                                <div
                                                                    class="select-option form-row-between invalid multi">{{$choice->choice}}</div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                            <div class="mb-0">
                                                <button type="submit" class="btn btn-primary">Submit Requirements
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @if ($order->status == 1 || $order->status == 2)
                        <div class="card mb-4 time-left">
                            <div class="card-header" id="count_title">Time left to deliver</div>
                            <div class="card-body">
                                <div class="col-md-12 d-flex justify-content-between align-items-center my-2">
                                    <div class="d-flex flex-column align-items-center" style="width: 23%;">
                                        <h5 id="count_day">00</h5>
                                        <p class="opacity-70 mb-0">Days</p>
                                    </div>
                                    <div class="bg-black opacity-70" style="width: 1px; height: 30px;"></div>
                                    <div class="d-flex flex-column align-items-center" style="width: 23%;">
                                        <h5 id="count_hour">00</h5>
                                        <p class="opacity-70 mb-0">Hours</p>
                                    </div>
                                    <div class="bg-black opacity-70" style="width: 1px; height: 30px;"></div>
                                    <div class="d-flex flex-column align-items-center" style="width: 23%;">
                                        <h5 id="count_min">00</h5>
                                        <p class="opacity-70 mb-0">Minutes</p>
                                    </div>
                                    <div class="bg-black opacity-70" style="width: 1px; height: 30px;"></div>
                                    <div class="d-flex flex-column align-items-center" style="width: 23%;">
                                        <h5 id="count_sec">00</h5>
                                        <p class="opacity-70 mb-0">Seconds</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4 order-details">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ $order->service->uploads->getImageOptimizedFullName(150) }}" alt=""
                                         class="thumbnail border w-100">
                                </div>
                                <div class="col-9">
                                    <div class="fs-18 fw-700">{{ $order->service->name }}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <span>Status</span>
                                <span>{{ Config::get('constants.service_order_status')[$order->status] }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <span>Ordered from</span>
                                <span>{{ $seller->first_name . " " . $seller->last_name }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <span>Delivery Date</span>
                                <span>{{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <span>Total Price</span>
                                <span>${{ number_format($order->package_price / 100, 2) }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <span>Order Number</span>
                                <span>{{ $order->order_id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('dropzone/js/dropzone.js') }}"></script>
        <script>
            $('#message').trumbowyg();

            var countDownDate = new Date("{{ $order->original_delivery_time }}".replace(" ", "T")).getTime()

            function padLeadingZeros(num, size) {
                if (!num) return "00";
                if (num < 0) return "00";
                var s = num + "";
                while (s.length < size) s = "0" + s;
                return s;
            }

            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $('#count_day').text(padLeadingZeros(days, 2));
                $('#count_hour').text(padLeadingZeros(hours, 2));
                $('#count_min').text(padLeadingZeros(minutes, 2));
                $('#count_sec').text(padLeadingZeros(seconds, 2));
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $('#count_title').text("Delivery time has already passed");
                }
            }, 1000);

            var uploadedFileData = [];
            Dropzone.autoDiscover = false;
            $(document).ready(function () {
                $(".attach-dropzone").dropzone({
                    method: 'post',
                    url: "{{ route('seller.file.store') }}",
                    dictDefaultMessage: "Select File",
                    paramName: "file",
                    maxFilesize: 256,
                    clickable: true,
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (file, response) {
                        var answerInput = $($(this)[0].element).parent().find(".answer");
                        var inputDiv = $($(this)[0].element).parent().find(".attach-dropzone");
                        var lastFiles = answerInput.val() ? answerInput.val().split(',') : [];
                        lastFiles.push(response.id);

                        answerInput.val(lastFiles.join(','));
                        response.requirementId = answerInput.data("id");
                        uploadedFileData.push(response);
                        inputDiv.removeClass("invalid").removeClass("valid").addClass("valid");
                    },
                    removedfile: function (file) {
                        var answerInput = $($(this)[0].element).parent().find(".answer");
                        var inputDiv = $($(this)[0].element).parent().find(".attach-dropzone");
                        for (var i = 0; i < uploadedFileData.length; ++i) {
                            if (!uploadedFileData[i]) {
                                continue;
                            }
                            if (uploadedFileData[i].file_original_name + "." + uploadedFileData[i].extension == file.name && uploadedFileData[i].requirementId == answerInput.data("id")) {
                                $.ajax({
                                    url: `/seller/file/destroy/${uploadedFileData[i].id}`,
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    },
                                    success: function (result) {
                                        var lastValue = answerInput.val().split(',');
                                        var removed = lastValue.filter((item) => item != uploadedFileData[i].id);
                                        answerInput.val(removed);
                                        $(file.previewElement).remove();
                                        uploadedFileData.splice(i, 1)

                                        if (removed.length == 0) {
                                            inputDiv.removeClass("invalid").removeClass("valid").addClass("invalid");
                                        }
                                    },
                                    error: function (error) {
                                        return false;
                                    }
                                });
                                break;
                            }
                        }
                    }
                })

                $('.select-option.multi').click(function () {
                    $(this).toggleClass("selected")
                    if ($(this).parent().find('.selected').length == 0) {
                        $(this).parent().children().addClass("invalid")
                    } else {
                        $(this).parent().children().removeClass("invalid")
                    }

                    setInput(this);
                })

                $('.select-option.single').click(function () {
                    if ($(this).hasClass("selected")) {
                        $(this).parent().children().removeClass("selected")
                    } else {
                        $(this).parent().children().removeClass("selected")
                        $(this).addClass("selected")
                    }

                    if ($(this).parent().find('.selected').length == 0) {
                        $(this).parent().children().addClass("invalid")
                    } else {
                        $(this).parent().children().removeClass("invalid")
                    }

                    setInput(this);
                })

                $('#question-form').submit(function (event) {
                    if ($(this).find('.required .invalid').length) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    $(this).addClass('was-validated');
                })
            })

            function setInput(item) {
                var inputItem = $(item).parent().find('input.answer');
                items = $(item).parent().find('.selected');
                if (items.length == 0) {
                    inputItem.val("");
                } else if (items.length == 1) {
                    inputItem.val(items.text());
                } else {
                    itemTexts = [];
                    for (const one of items) {
                        itemTexts.push($(one).text());
                    }
                    inputItem.val(itemTexts.join(','));
                }
            }
        </script>
    @endsection

</x-app-layout>
