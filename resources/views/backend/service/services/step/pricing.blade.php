<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  /> -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>
    .submission {
        background-color: #fafafa;
        width: 31%;
        border: 2px solid #dddddd;
        display: flex;
        align-items: flex-end;
        font-weight: bold;
        font-size: 14px;
        color: #444;
        padding: 20px;
    }

    .package-title {
        font-weight: bold;
        font-size: 15px;
        background-color: #fafafa;
        border: 2px solid #dddddd;
        border-left: none;
        padding: 20px;
        color: #444;
    }

    .sub-content {
        border-right: 2px solid #ddd;
        border-bottom: 2px solid #ddd;
    }

    .sub-content textarea {
        border: none;
        outline: none;
        resize: none;
    }

    .sub-content svg {
        margin: 10px;
    }

    .select-none {
        border: none;
        outline: none;
        margin: 10px 0;
        font-size: 15px;
    }

    .select-none:focus {
        border: none;
        outline: none;
        box-shadow: none;
    }

    .w-30 {
        width: 23%;
    }
    .text-input-package {
        padding: 10px 15px;
        outline: none;
        margin: 10px 0;
        border: none;
        font-size: 15px;
    }
    .try-triple-packages {
        width: 46%;
        position: absolute;
        top: 1px;
        right: 1px;
        background-color: #fff;
        opacity: .9;
        height: calc(100% - 2px);
        text-align: center;
    }
    .try-triple-packages>b {
        padding-top: 120px;
        margin: 16px 0;
        width: 260px;
        display: inline-block;
    }
    .try-triple-packages .try-btn-wrapper {
        margin-bottom: 10px;
    }
    .ps-relative {
        position: relative;
    }
    .btn-default {
        --bs-btn-color: #000;
        --bs-btn-bg: #f8f9fa;
        --bs-btn-border-color: #f8f9fa;
        --bs-btn-hover-color: #000;
        --bs-btn-hover-bg: #f9fafb;
        --bs-btn-hover-border-color: #f9fafb;
        --bs-btn-focus-shadow-rgb: 211,212,213;
        --bs-btn-active-color: #000;
        --bs-btn-active-bg: #f9fafb;
        --bs-btn-active-border-color: #f9fafb;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #000;
        --bs-btn-disabled-bg: #f8f9fa;
        --bs-btn-disabled-border-color: #f8f9fa;
    }
</style>
<form action="{{ route('backend.services.package') }}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Service Package</h4>
                    <div>
                        Offer Packages: <input data-id="" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive">
                    </div>
                </div>
                <div class="card-body ps-relative">
                    <div class="d-flex w-100 justify-content-between">
                        <input type="hidden" name="service_id" id="service_id" value="{{$post_id}}" >
                        <input type="hidden" name="step" id="step" value="{{$step}}" >
                        <div class="submission">Revision</div>
                        <div class="w-30">
                            <div class="package-title">BASIC</div>
                            <input type="hidden" name="type[]" value="1"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" placeholder="Name your package"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option selected>Delivery Time</option>
                                    <option value="1">1 day Delivery</option>
                                    <option value="2">2 day Delivery</option>
                                    <option value="3">3 day Delivery</option>
                                    <option value="3">4 day Delivery</option>
                                    <option value="3">5 day Delivery</option>
                                    <option value="3">6 day Delivery</option>
                                    <option value="3">7 day Delivery</option>
                                    <option value="3" disabled>-</option>
                                    <option value="3">10 day Delivery</option>
                                    <option value="3">14 day Delivery</option>
                                    <option value="3">21 day Delivery</option>
                                    <option value="3" disabled>-</option>
                                    <option value="3">30 day Delivery</option>
                                    <option value="3">45 day Delivery</option>
                                    <option value="3">60 day Delivery</option>
                                    <option value="3">75 day Delivery</option>
                                    <option value="3">90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                <input type="text" name="revisions[]" class="w-100 text-input-package" placeholder="Revision of your package">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="package-title">STANDARD</div>
                            <input type="hidden" name="type[]" value="2"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" placeholder="Name your package"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option selected>Delivery Time</option>
                                    <option value="1">1 day Delivery</option>
                                    <option value="2">2 day Delivery</option>
                                    <option value="3">3 day Delivery</option>
                                    <option value="3">4 day Delivery</option>
                                    <option value="3">5 day Delivery</option>
                                    <option value="3">6 day Delivery</option>
                                    <option value="3">7 day Delivery</option>
                                    <option value="3" disabled>-</option>
                                    <option value="3">10 day Delivery</option>
                                    <option value="3">14 day Delivery</option>
                                    <option value="3">21 day Delivery</option>
                                    <option value="3" disabled>-</option>
                                    <option value="3">30 day Delivery</option>
                                    <option value="3">45 day Delivery</option>
                                    <option value="3">60 day Delivery</option>
                                    <option value="3">75 day Delivery</option>
                                    <option value="3">90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                <input type="text" name="revisions[]" class="w-100 text-input-package" placeholder="Revision of your package">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="package-title">PREMIUM</div>
                            <input type="hidden" name="type[]" value="3"/>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="name[]" id="name" rows="4" maxlength="35" class="w-100" placeholder="Name your package"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <textarea type="text" name="description[]" id="description" rows="6" maxlength="35" class="w-100" placeholder="Describe the details of your offering"></textarea>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </div>
                            <div class="d-flex sub-content">
                                <select class="form-select select-none" name="delivery_time[]" aria-label="Default select example">
                                    <option selected>Delivery Time</option>
                                    <option value="1">1 day Delivery</option>
                                    <option value="2">2 day Delivery</option>
                                    <option value="3">3 day Delivery</option>
                                    <option value="4">4 day Delivery</option>
                                    <option value="5">5 day Delivery</option>
                                    <option value="6">6 day Delivery</option>
                                    <option value="7">7 day Delivery</option>
                                    <option disabled>-</option>
                                    <option value="10">10 day Delivery</option>
                                    <option value="14">14 day Delivery</option>
                                    <option value="21">21 day Delivery</option>
                                    <option disabled>-</option>
                                    <option value="30">30 day Delivery</option>
                                    <option value="45">45 day Delivery</option>
                                    <option value="60">60 day Delivery</option>
                                    <option value="75">75 day Delivery</option>
                                    <option value="90">90 day Delivery</option>
                                </select>
                            </div>
                            <div class="d-flex sub-content">
                                <input type="text" name="revisions[]" class="w-100 text-input-package" placeholder="Revision of your package">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                        <div class="submission">Price ($)</div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package">
                            </div>
                        </div>
                        <div class="w-30">
                            <div class="d-flex sub-content">
                                <input type="number" name="price[]" class="w-100 text-input-package" placeholder="Price of your package">
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

    <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
        <!-- Card -->
        <div class="card card-sm bg-dark border-dark mx-2">
            <div class="card-body">
                <div class="row justify-content-center justify-content-sm-between">
                    <div class="col">
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-light">Save Draft</button>
                            <button type="submit" class="btn btn-primary">Save & Continue</button>
                        </div>
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
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
        if(status == 1) {
            $('.try-triple-packages').css('display', 'none')
        } else {
            $('.try-triple-packages').css('display', 'block')
        }
    })
  })
  function setofferpk() {
    $('.toggle-class').prop('checked', 'checked')
    $('.try-triple-packages').css('display', 'none')
  }
</script>