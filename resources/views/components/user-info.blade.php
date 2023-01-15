<div class="row">
    <div class="col-6">
        <div class="form-floating mb-3">
            <label for="floatingFirstName">First name</label>
            <input type="text" name="first_name" value="{{ $billing->first_name ?? old('first_name') }}" id="floatingFirstName"
                class="form-control" required placeholder="Enter Ffirst name">
        </div>
    </div>
    <div class="col-6">
        <div class="form-floating mb-3">
            <label for="floatingLastName">Last name</label>
            <input type="text" name="last_name" value="{{ $billing->last_name ?? old('last_name') }}" id="floatingLastName"
                class="form-control" required placeholder="Enter last name">
        </div>
    </div>
</div>
@if (guest_checkout() && auth()->user() == null)
@if (\Route::currentRouteName() == 'checkout.billing.get')
    <div class="form-floating mb-3">
        <label for="floatingEmail">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" id="floatingEmail"
            class="form-control" required placeholder="Enter Email">
    </div>
@endif
@endif
<div class="form-floating mb-3">
    <label for="floatingAddress">Address</label>
    <input type="text" name="address1" value="{{ $billing->address ?? old('address1') }}" id="floatingAddress"
        class="form-control" required placeholder="Enter Address">
</div>
<div class="form-floating mb-3">
    <label for="floatingAddress2">Secondary Address</label>
    <input type="text" name="address2" value="{{ $billing->address2 ?? old('address2') }}" id="floatingAddress2"
        class="form-control" placeholder="Enter Secondary Address (optional)">
</div>
<div class="form-floating mb-3">
    <label for="floatingCity">City</label>
    <input type="text" name="city" value="{{ $billing->city ?? old('city') }}" id="floatingCity"
        class="form-control" required placeholder="Enter City">
</div>
<div class="form-floating mb-3">
    <label for="floatingState">State</label>
    <input type="text" name="state" value="{{ $billing->state ?? old('state') }}" id="floatingState"
        class="form-control" required placeholder="Enter State">
</div>
<div class="form-floating mb-3">
    <label for="floatingCountry">Country</label>
    <select name="country" id="floatingCountry" data-live-search="true" class="form-control">
        @foreach ($countries as $country)
            @if (( auth()->user() && auth()->user()->address && $billing !== "NULL" && $billing->country == $country->code) || $country->name == $location->country )
                <option value="{{ $country->code }}" selected>{{ $country->name }}</option>
            @else
                <option value="{{ $country->code }}">{{ $country->name }}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="form-floating mb-3">
    <label for="floatingZipcode">Zipcode</label>
    <input type="text" name="pin_code" value="{{ $billing->postal_code ?? old('pin_code') }}"
        id="floatingZipcode pin_code" class="form-control" required placeholder="Enter PIN Code">
</div>
<div class="form-floating mb-3">
    <label for="floatingPhonenumber">Phone Number</label>
    <input type="tel" name="phone" value="{{ $billing->phone ?? old('pin_code') }}" id="floatingPhonenumber" class="form-control" placeholder="Enter Phone Number">
</div>
