@if ($tab == "account")
<div class="card mb-4 p-0">
    <div class="card-header">User Information</div>
    <div class="card-body">
        @if ($edit)
            <div class="mb-2">
                <label for="name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') ?? $user->first_name }}"
                    class="form-control">
            </div>
            <div class="mb-2">
                <label for="name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') ?? $user->last_name }}"
                    class="form-control">
            </div>
            <div class="mb-2">
                <label for="name">Username:</label>
                <input type="text" name="username" id="username" value="{{ old('username') ?? $user->username }}"
                    class="form-control">
            </div>
        @else
            <div class="mb-2">
                <label for="name">Name:</label>
                <input {{ $edit ? null : 'disabled' }} type="text" name="name" id="name"
                    value="{{ old('name') ?? $user->first_name . ' ' . $user->last_name }}"
                    placeholder="{{ $user->first_name . ' ' . $user->last_name }}" class="form-control">
            </div>
        @endif
        <div class="mb-2">
            <label for="email">Email:</label>
            <input disabled type="text" id="email" value="{{ $user->email }}" placeholder="{{ $user->email }}"
                class="form-control">
        </div>
    </div>
</div>

<div class="card mb-4 p-0">
    <div class="card-header">Avatar</div>
    <div class="card-body">
        <div class="col-md-6">
            <!-- Card -->
            @if ($edit)
            <input type="hidden" name="avatar" class="avatar" id="avatar" value="{{ $user->avatar }}">
            <div>
                <div class="dropzone" id="avatar_dropzone"></div>
            </div>
            @else
            <div class="imagePreview pt-2 img-thumbnail">
                <img id="fileManagerPreview" src="{{ $user->uploads->getImageOptimizedFullName(200,200) }}" class="rounded-circle w-100">
            </div>
            @endif
            <!-- End Card -->
        </div>
    </div>
</div>
@elseif($tab == "address")
<div class="card mb-4 p-0">
    <div class="card-header">Shipping Address</div>
    <div class="card-body">
        <div class="mb-2">
            <label for="shipping_address1">Address:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="shipping_address1" id="shipping_address1"
                value="{{ old('shipping_address1') ?? ($shipping->address ?? '') }}"
                placeholder="{{ $shipping->address ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="shipping_address2">Secondary Address:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="shipping_address2" id="shipping_address2"
                value="{{ old('address2') ?? ($shipping->address2 ?? '') }}"
                placeholder="{{ $shipping->address2 ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="shipping_city">City:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="shipping_city" id="shipping_city"
                value="{{ old('shipping_city') ?? ($shipping->city ?? '') }}"
                placeholder="{{ $shipping->city ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="shipping_state">State:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="shipping_state" id="shipping_state"
                value="{{ old('shipping_state') ?? ($shipping->state ?? '') }}"
                placeholder="{{ $shipping->state ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="shipping_pin_code">Zip Code:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="shipping_pin_code" id="shipping_pin_code"
                value="{{ old('shipping_pin_code') ?? ($shipping->postal_code ?? '') }}"
                placeholder="{{ $shipping->postal_code ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="shipping_country">Country:</label>
            <select name="shipping_country" id="shipping_country" class="form-control" {{ $edit ? null : 'disabled' }}
                value="{{ old('country') ?? ($shipping->country ?? '') }}"
            >
                <option value="">Choose Country</option>
                @foreach($countries as $country)
                    <option {{ (old('country') ?? ($shipping->country ?? '')) == $country["code"] ?"selected" :""}}
                            value="{{$country["code"]}}">{{$country["name"]}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div><!-- end shipping-address-->
<div class="card p-0">
    <div class="card-header">Billing Address</div>
    <div class="card-body">
        <div class="mb-2">
            <label for="billing_address1">Address:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="billing_address1" id="billing_address1"
                value="{{ old('billing_address1') ?? ($billing->address ?? '') }}"
                placeholder="{{ $billing->address ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="billing_address2">Secondary Address:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="billing_address2" id="billing_address2"
                value="{{ old('billing_address2') ?? ($billing->address2 ?? '') }}"
                placeholder="{{ $billing->address2 ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="billing_city">City:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="billing_city" id="billing_city"
                value="{{ old('billing_city') ?? ($billing->city ?? '') }}" placeholder="{{ $billing->city ?? '' }}"
                class="form-control">
        </div>
        <div class="mb-2">
            <label for="billing_state">State:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="billing_state" id="billing_state"
            value="{{ old('billing_state') ?? ($billing->state ?? '') }}"
            placeholder="{{ $billing->state ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="billing_pin_code">Zip Code:</label>
            <input {{ $edit ? null : 'disabled' }} type="text" name="billing_pin_code" id="billing_pin_code"
                value="{{ old('billing_pin_code') ?? ($billing->postal_code ?? '') }}"
                placeholder="{{ $billing->postal_code ?? '' }}" class="form-control">
        </div>
        <div class="mb-2">
            <label for="billing_country">Country:</label>
            <select name="billing_country" id="billing_country" class="form-control" {{ $edit ? null : 'disabled' }}
            value="{{ old('country') ?? ($billing->country ?? '') }}"
            >
                <option value="">Choose Country</option>
                @foreach($countries as $country)
                    <option {{ (old('country') ?? ($billing->country ?? '')) == $country["code"] ?"selected" :""}}
                            value="{{$country["code"]}}">{{$country["name"]}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div><!-- end billing-address-->
@endif

<div id='ajaxCalls'></div>

@section('js')
<script>
$(document).ready(function() {
    $('body').on('click', '#getFileManager', function () {
        $.ajax({
            url: "{{ route('backend.file.show') }}",
            success: function (data) {
                if (!$.trim($('#fileManagerContainer').html()))
                    $('#fileManagerContainer').html(data);

                $('#fileManagerModal').modal('show');

                const getSelectedItem = function (selectedId, filePath) {

                    $('#fileManagerId').val(selectedId);
                    $('#fileManagerPreview').attr('src', filePath);
                }

                setSelectedItemsCB(getSelectedItem, $('#fileManagerId').val() == '' ? [] : [$('#fileManagerId').val()], false);
            }
        })
    });
});
</script>
@endsection
