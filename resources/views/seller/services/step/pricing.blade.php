<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<form action="{{ route('seller.services.package') }}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-6 col-lg-8 mx-auto">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Packages</h4>
                    <div class="">
                        Offer Packages: <input data-id="" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{count($data->packages) == 3 ? "checked": ""}}>
                    </div>
                </div>
                <div class="card-body ps-relative">
                    <div class="d-flex w-100 justify-content-between">
                        <input type="hidden" name="service_id" id="service_id" value="{{$post_id}}" >
                        <input type="hidden" name="step" id="step" value="{{$step}}" >
                        <input type="hidden" name="package_count" id="package_count" value="{{count($data->packages) == 0 ? 1 : count($data->packages)}}" >
                        <div class="submission">Revision</div>
                        <div class="w-30">
                            <div class="package-title">BASIC</div>
                            <input type="hidden" name="type[]" value="1"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" value="Basic" placeholder="Name your package">{{isset($packages) ? (count($packages) >= 1 ? $packages[0]->name : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering">{{isset($packages) ? (count($packages) >= 1 ? $packages[0]->description : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 1 ? $packages[0]->delivery_time : 0) : 0)
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option {{$value === 0 ? "selected": ""}}>Delivery Time</option>
                                    <option value="1" {{$value === 1 ? "selected": ""}}>1 day Delivery</option>
                                    <option value="2" {{$value === 2 ? "selected": ""}}>2 day Delivery</option>
                                    <option value="3" {{$value === 3 ? "selected": ""}}>3 day Delivery</option>
                                    <option value="4" {{$value === 4 ? "selected": ""}}>4 day Delivery</option>
                                    <option value="5" {{$value === 5 ? "selected": ""}}>5 day Delivery</option>
                                    <option value="6" {{$value === 6 ? "selected": ""}}>6 day Delivery</option>
                                    <option value="7" {{$value === 7 ? "selected": ""}}>7 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="10" {{$value === 10 ? "selected": ""}}>10 day Delivery</option>
                                    <option value="14" {{$value === 14 ? "selected": ""}}>14 day Delivery</option>
                                    <option value="21" {{$value === 21 ? "selected": ""}}>21 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="30" {{$value === 30 ? "selected": ""}}>30 day Delivery</option>
                                    <option value="45" {{$value === 45 ? "selected": ""}}>45 day Delivery</option>
                                    <option value="60" {{$value === 60 ? "selected": ""}}>60 day Delivery</option>
                                    <option value="75" {{$value === 75 ? "selected": ""}}>75 day Delivery</option>
                                    <option value="90" {{$value === 90 ? "selected": ""}}>90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 1 ? $packages[0]->revisions : -1) : -1)
                                <select type="text" name="revisions[]" class="form-select select-none" placeholder="Revision of your package">
                                    <option {{$value === -1 ? "selected": ""}}>Select</option>
                                    <option value="0" {{$value === "0" ? "selected": ""}}>0</option>
                                    <option value="1" {{$value === "1" ? "selected": ""}}>1</option>
                                    <option value="2" {{$value === "2" ? "selected": ""}}>2</option>
                                    <option value="3" {{$value === "3" ? "selected": ""}}>3</option>
                                    <option value="4" {{$value === "4" ? "selected": ""}}>4</option>
                                    <option value="5" {{$value === "5" ? "selected": ""}}>5</option>
                                    <option value="6" {{$value === "6" ? "selected": ""}}>6</option>
                                    <option value="7" {{$value === "7" ? "selected": ""}}>7</option>
                                    <option value="8" {{$value === "8" ? "selected": ""}}>8</option>
                                    <option value="9" {{$value === "9" ? "selected": ""}}>9</option>
                                    <option value="999" {{$value === "999" ? "selected": ""}}>UNLIMIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="package-title">STANDARD</div>
                            <input type="hidden" name="type[]" value="2"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" value="Standard" placeholder="Name your package">{{isset($packages) ? (count($packages) >= 2 ? $packages[1]->name : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering">{{isset($packages) ? (count($packages) >= 2 ? $packages[1]->description : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 2 ? $packages[1]->delivery_time : 0) : 0)
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option {{$value === 0 ? "selected": ""}}>Delivery Time</option>
                                    <option value="1" {{$value === 1 ? "selected": ""}}>1 day Delivery</option>
                                    <option value="2" {{$value === 2 ? "selected": ""}}>2 day Delivery</option>
                                    <option value="3" {{$value === 3 ? "selected": ""}}>3 day Delivery</option>
                                    <option value="4" {{$value === 4 ? "selected": ""}}>4 day Delivery</option>
                                    <option value="5" {{$value === 5 ? "selected": ""}}>5 day Delivery</option>
                                    <option value="6" {{$value === 6 ? "selected": ""}}>6 day Delivery</option>
                                    <option value="7" {{$value === 7 ? "selected": ""}}>7 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="10" {{$value === 10 ? "selected": ""}}>10 day Delivery</option>
                                    <option value="14" {{$value === 14 ? "selected": ""}}>14 day Delivery</option>
                                    <option value="21" {{$value === 21 ? "selected": ""}}>21 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="30" {{$value === 30 ? "selected": ""}}>30 day Delivery</option>
                                    <option value="45" {{$value === 45 ? "selected": ""}}>45 day Delivery</option>
                                    <option value="60" {{$value === 60 ? "selected": ""}}>60 day Delivery</option>
                                    <option value="75" {{$value === 75 ? "selected": ""}}>75 day Delivery</option>
                                    <option value="90" {{$value === 90 ? "selected": ""}}>90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 2 ? $packages[1]->revisions : -1) : -1)
                                <select type="text" name="revisions[]" class="form-select select-none" placeholder="Revision of your package">
                                    <option {{$value === -1 ? "selected": ""}}>Select</option>
                                    <option value="0" {{$value === "0" ? "selected": ""}}>0</option>
                                    <option value="1" {{$value === "1" ? "selected": ""}}>1</option>
                                    <option value="2" {{$value === "2" ? "selected": ""}}>2</option>
                                    <option value="3" {{$value === "3" ? "selected": ""}}>3</option>
                                    <option value="4" {{$value === "4" ? "selected": ""}}>4</option>
                                    <option value="5" {{$value === "5" ? "selected": ""}}>5</option>
                                    <option value="6" {{$value === "6" ? "selected": ""}}>6</option>
                                    <option value="7" {{$value === "7" ? "selected": ""}}>7</option>
                                    <option value="8" {{$value === "8" ? "selected": ""}}>8</option>
                                    <option value="9" {{$value === "9" ? "selected": ""}}>9</option>
                                    <option value="999" {{$value === "999" ? "selected": ""}}>UNLIMIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="package-title">PREMIUM</div>
                            <input type="hidden" name="type[]" value="3"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" value="Premium" placeholder="Name your package">{{isset($packages) ? (count($packages) >= 3 ? $packages[2]->name : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering">{{isset($packages) ? (count($packages) >= 3 ? $packages[2]->description : "") : "" }}</textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 3 ? $packages[2]->delivery_time : 0) : 0)
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option {{$value === 0 ? "selected": ""}}>Delivery Time</option>
                                    <option value="1" {{$value === 1 ? "selected": ""}}>1 day Delivery</option>
                                    <option value="2" {{$value === 2 ? "selected": ""}}>2 day Delivery</option>
                                    <option value="3" {{$value === 3 ? "selected": ""}}>3 day Delivery</option>
                                    <option value="4" {{$value === 4 ? "selected": ""}}>4 day Delivery</option>
                                    <option value="5" {{$value === 5 ? "selected": ""}}>5 day Delivery</option>
                                    <option value="6" {{$value === 6 ? "selected": ""}}>6 day Delivery</option>
                                    <option value="7" {{$value === 7 ? "selected": ""}}>7 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="10" {{$value === 10 ? "selected": ""}}>10 day Delivery</option>
                                    <option value="14" {{$value === 14 ? "selected": ""}}>14 day Delivery</option>
                                    <option value="21" {{$value === 21 ? "selected": ""}}>21 day Delivery</option>
                                    <option value="" disabled>-</option>
                                    <option value="30" {{$value === 30 ? "selected": ""}}>30 day Delivery</option>
                                    <option value="45" {{$value === 45 ? "selected": ""}}>45 day Delivery</option>
                                    <option value="60" {{$value === 60 ? "selected": ""}}>60 day Delivery</option>
                                    <option value="75" {{$value === 75 ? "selected": ""}}>75 day Delivery</option>
                                    <option value="90" {{$value === 90 ? "selected": ""}}>90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                @php ($value = isset($packages) ? (count($packages) >= 3 ? $packages[2]->revisions : -1) : -1)
                                <select type="text" name="revisions[]" class="form-select select-none" placeholder="Revision of your package">
                                    <option {{$value === -1 ? "selected": ""}}>Select</option>
                                    <option value="0" {{$value === "0" ? "selected": ""}}>0</option>
                                    <option value="1" {{$value === "1" ? "selected": ""}}>1</option>
                                    <option value="2" {{$value === "2" ? "selected": ""}}>2</option>
                                    <option value="3" {{$value === "3" ? "selected": ""}}>3</option>
                                    <option value="4" {{$value === "4" ? "selected": ""}}>4</option>
                                    <option value="5" {{$value === "5" ? "selected": ""}}>5</option>
                                    <option value="6" {{$value === "6" ? "selected": ""}}>6</option>
                                    <option value="7" {{$value === "7" ? "selected": ""}}>7</option>
                                    <option value="8" {{$value === "8" ? "selected": ""}}>8</option>
                                    <option value="9" {{$value === "9" ? "selected": ""}}>9</option>
                                    <option value="999" {{$value === "999" ? "selected": ""}}>UNLIMIT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        <div class="submission">Price ($)</div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package" value="{{isset($packages) ? (count($packages) >= 1 ? $packages[0]->price / 100 : 0) : 0 }}">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package" value="{{isset($packages) ? (count($packages) >= 2 ? $packages[1]->price / 100 : 0) : 0 }}">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package" value="{{isset($packages) ? (count($packages) >= 3 ? $packages[2]->price / 100 : 0) : 0 }}">
                            </div>
                        </div>
                    </div>
                    <div class="try-triple-packages">
                        <b>Offer packages to meet the needs of more buyers.</b>
                        <div class="try-btn-wrapper">
                            <button class="btn btn-primary" type="button" tabindex="-1" onclick="javascript:setofferpk()">Create Packages</button>
                        </div>
                    </div>
                    @include('includes.validation-form')
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-8 mx-auto">
            <div class="row justify-content-center justify-content-sm-between">
                <div class="col">
                    <a class="btn btn-danger" href="{{route('seller.services.list')}}">Cancel</a>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-column gap-3">
                        <button type="submit" class="btn btn-primary">Save & Continue</button>
                        <a class="btn btn-light" href="{{"/seller/services/create/".($step-1)."/".$post_id}}">Back</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<div id='ajaxCalls'>
</div>
<script>
  $(function() {
    {!!isset($packages) ? (count($packages) >= 3 ? "$('.try-triple-packages').css('display', 'none')" : "") : "" !!}
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
        if(status == 1) {
            $('.try-triple-packages').css('display', 'none')
            $('#package_count').val(3)
        } else {
            $('.try-triple-packages').css('display', 'block')
            $('#package_count').val(1)
        }
    })
  })
  function setofferpk() {
    $('.toggle-class').bootstrapToggle('on')
    $('.try-triple-packages').css('display', 'none')
    $('#package_count').val(3)
  }
</script>
