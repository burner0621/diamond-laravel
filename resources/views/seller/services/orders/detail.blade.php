<x-app-layout :page-title="'ORDER #' . $order->order_id">
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
                <div class="col-9">
                    @include('includes.validation-form')
                    @if (session('success'))
                        <!--<div class="alert alert-success" role="alert">{{session('success')}}</div>-->
                    @endif
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="fw-700">Order Started</h4>
                            @if ($order->status == 0)
                                <p class="p-0">Pending requirements in order to start job. Contact to
                                    <b>{{ $order->user->first_name . " " . $order->user->last_name }}</b> and let them
                                    know to submit the requirements.</p>
                            @else
                                <p class="p-0"><b>{{ $order->user->first_name . " " . $order->user->last_name }}</b>
                                    sent all the information you need so you can start working on this order. You got
                                    this!</p>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="timeline-item pb-3 mb-3 border-bottom">
                                <i class="bi bi-clipboard-check p-1"></i>
                                <span class=""><b>{{ $order->user->first_name . " " . $order->user->last_name }}</b> placed the order {{ date('F d, Y h:i A', strtotime($order->created_at)) }}</span>
                            </div>
                            @if ($order->status != 0)
                                <div class="timeline-item pb-3 mb-3 border-bottom">
                                    <i class="bi bi-clipboard-check p-1"></i>
                                    <span class=""><b>{{ $order->user->first_name . " " . $order->user->last_name }}</b> sent the requirements {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                </div>

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
                            <div class="timeline-item pb-3 mb-3 border-bottom">
                                <i class="bi bi-clipboard-check p-1"></i>
                                <span class="">The order started {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                            </div>
                            <div class="timeline-item pb-3 mb-3 border-bottom">
                                <i class="bi bi-clipboard-check p-1"></i>
                                <span class="">Your delivery date was updated to {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                            </div>

                            @if (count($deliveries) > 0)
                                <div class="timeline-item pb-3 mb-3 border-bottom">
                                    <i class="bi bi-clipboard-check p-1"></i>
                                    <span class="">You delivered the order {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
                                </div>
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

                                @if ($delivery->revision)
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span class="">{{$buyer->first_name . " " . $buyer->last_name}} requested a revision on this delivery {{ date('F d, Y h:i A', strtotime($order->original_delivery_time)) }}</span>
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
                                    <span class="">Your approved delivery at {{ date('F d, Y h:i A', strtotime($order->updated_at)) }}. Order completed</span>
                                </div>
                                @if (count($order->review))
                                    <div class="timeline-item pb-3 mb-3 border-bottom">
                                        <i class="bi bi-clipboard-check p-1"></i>
                                        <span class="">{{$order->user->first_name . "" . $order->user->last_name }} left a review to your service at {{ date('F d, Y h:i A', strtotime($order->review[0]->created_at)) }}</span>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{$order->user->first_name . "" . $order->user->last_name }}'s
                                                Review</h5>
                                        </div>
                                        <div class="card-body">
                                            @if(count($order->review) == 2)
                                                <div class="rate pb-3">
                                                    @for ($i = 5; $i > 0; $i--)
                                                        <input
                                                                type="radio" id="star{!! $i !!}" class="rate"
                                                                name="rating1"
                                                                value="{!! $i !!}"
                                                                {{ $order->review[0]->rating == $i ? "checked" : "" }}
                                                                disabled
                                                        />
                                                        <label for="star{!! $i !!}">{{ $i }}</label>
                                                    @endfor
                                                </div>
                                                <div style="clear: left">
                                                    {{ $order->review[0]->review }}
                                                </div>
                                            @else
                                                Rate the buyer({{ $order->user->full_name }}) to see their review.
                                            @endif
                                        </div>
                                    </div>
                                    @if (count($order->review) == 2)
                                        <div class="timeline-item pb-3 mb-3 border-bottom">
                                            <i class="bi bi-clipboard-check p-1"></i>
                                            <span class="">You sent a review to {{$order->user->first_name . " " . $order->user->last_name}} at {{ date('F d, Y h:i A', strtotime($order->review[1]->created_at)) }}</span>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Your Review</h5>
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
                                                <div style="clear: left">
                                                    {{ $order->review[1]->review }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('services.review', $order->order_id) }}">Rate the buyer</a>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-3">
                    <div class="card mb-4 time-left">
                        <div class="card-header" id="count_title">Time left to deliver</div>
                        <div class="card-body">
                            @if ($order->status == 1 || $order->status == 2)
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
                                @if($order->status == 1 && $order->order_service_revision_requests->count() == 0)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#deliverModal">
                                        Deliver Now
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#deliverModal">
                                        Deliver again
                                    </button>
                                @endif
                            @elseif ($order->status == 0)
                                <div class="col-md-12">
                                    Didn't receive requirement yet
                                </div>
                            @elseif ($order->status == 3)
                                <div class="col-md-12">
                                    Order canceled
                                </div>
                            @elseif ($order->status == 4)
                                <div class="col-md-12">
                                    Delivered
                                </div>
                            @elseif ($order->status == 5)
                                <div class="col-md-12">
                                    Completed
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-4 order-details">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-3">
                                    <img src="{{ $order->service->uploads->getImageOptimizedFullName(150) }}" alt=""
                                         class="thumbnail border w-100">
                                </div>
                                <div class="col-9">
                                    <div class="fs-18 fw-700">{{ $order->service->name }}</div>
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
                                <span>{{ $buyer->first_name . " " . $buyer->last_name }}</span>
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

            <div class="modal fade modal-lg" id="deliverModal" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="deliverModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="delivery-form" class="needs-validation"
                              action="{{ route("seller.service.order.deliver") }}" method="post"
                              enctype="multipart/form-data" novalidate>
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deliverModalLabel">Deliver Service</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @csrf
                                        <div class="card col-md-12 mb-4">
                                            <!-- End Header -->
                                            <div class="card-body">
                                                <input type="hidden" name="order_id" id="order_id"
                                                       value="{{ $order->id }}">
                                                <div class="mb-2">
                                                    <label for="message" class="w-100 mb-2 required">Message</label>
                                                    <textarea name="message" id="message" rows="6" class="form-control"
                                                              required>{{ old('message') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="card mb-4">
                                                <!-- Header -->
                                                <div class="card-header card-header-content-between">
                                                    <label class="card-header-title mb-0 required">Attach</label>
                                                </div>
                                                <!-- End Header -->

                                                <!-- Body -->
                                                <div class="card-body requried">
                                                    <input type="hidden" class="attach" id="attach" name="attach"
                                                           value="">
                                                    <div id="attach_container">
                                                        <div class="dropzone invalid" id="attach-dropzone">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit Delivery</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('dropzone/js/dropzone.js') }}"></script>
        <script>
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

          Dropzone.autoDiscover = false;
          var uploadedFileData = [];
          $(document).ready(function () {
            $("#attach-dropzone").dropzone({
              method: 'post',
              url: "{{ route('seller.file.store') }}",
              dictDefaultMessage: "Select File",
              paramName: "file",
              maxFilesize: 2,
              clickable: true,
              addRemoveLinks: true,
              headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              },
              success: function (file, response) {
                var attachInput = $('#attach');
                var inputDiv = $("#attach-dropzone");
                var lastFiles = attachInput.val() ? attachInput.val().split(',') : [];
                lastFiles.push(response.id);

                attachInput.val(lastFiles.join(','));
                uploadedFileData.push(response);
                inputDiv.removeClass("invalid").removeClass("valid").addClass("valid");
              },
              removedfile: function (file) {
                var answerInput = $('#attach');
                var inputDiv = $("#attach-dropzone");
                for (var i = 0; i < uploadedFileData.length; ++i) {
                  if (!uploadedFileData[i]) {
                    continue;
                  }
                  if (uploadedFileData[i].file_original_name + "." + uploadedFileData[i].extension == file.name) {
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

            $('#delivery-form').submit(function (event) {
              if ($(this).find('.required .invalid').length) {
                event.preventDefault();
                event.stopPropagation();
              }

              $(this).addClass('was-validated');
            })
          });

          const deliverModal = document.getElementById('deliverModal')
          const messageInput = document.getElementById('message')

          deliverModal.addEventListener('shown.bs.modal', () => {
            messageInput.focus()
          })
        </script>
    @endsection

</x-app-layout>
