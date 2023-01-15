@extends('backend.layouts.app', ['activePage' => 'page', 'title' => 'General Settings', 'navName' => 'addpost', 'activeButton' => 'blog'])

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <h1 class="page-header-title">Settings</h1>
    </div>
    <!-- End Row -->
</div>

<form action="{{ route('backend.general.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">            
            <div class="card col-md-12 mb-4">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">General</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="mb-2">
                        <label for="sitename" class="w-100 mb-2"> Site Name:</label>
                        @if ($data && $data->sitename)
                        <input type="text" name="sitename" id="sitename" value="{{ $data->sitename }}" class="form-control">
                        @else
                        <input type="text" name="sitename" id="sitename" value="{{ old('sitename') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="meta_title" class="w-100 mb-2">Meta Title:</label>
                        @if ($data && $data->meta_title)
                        <input type="text" name="meta_title" id="meta_title" value="{{ $data->meta_title }}" class="form-control">
                        @else
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="meta_description" class="w-100 mb-2">Meta Description:</label>
                        @if ($data && $data->meta_description)
                        <textarea name="meta_description" id="meta_description" rows="6" class="form-control">{{ $data->meta_description }}</textarea>
                        @else
                        <textarea name="meta_description" id="meta_description" rows="6" class="form-control">{{ old('meta_description') }}</textarea>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="twitter" class="w-100 mb-2">Twitter:</label>
                        @if ($data && $data->twitter)
                        <input type="text" name="twitter" id="twitter" value="{{ $data->twitter }}" class="form-control">
                        @else
                        <input type="text" name="twitter" id="twitter" value="{{ old('twitter') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="facebook" class="w-100 mb-2">Instagram:</label>
                        @if ($data && $data->instagram)
                        <input type="text" name="facebook" id="facebook" value="{{ $data->instagram }}" class="form-control">
                        @else
                        <input type="text" name="facebook" id="facebook" value="{{ old('instagram') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="instagram" class="w-100 mb-2">Facebook:</label>
                        @if ($data && $data->facebook)
                        <input type="text" name="instagram" id="instagram" value="{{ $data->facebook }}" class="form-control">
                        @else
                        <input type="text" name="instagram" id="instagram" value="{{ old('facebook') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="youtube" class="w-100 mb-2">Youtube:</label>
                        @if ($data && $data->youtube)
                        <input type="text" name="youtube" id="youtube" value="{{ $data->youtube }}" class="form-control">
                        @else
                        <input type="text" name="youtube" id="youtube" value="{{ old('youtube') }}" class="form-control">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card col-md-12">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Stripe Settings</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="mb-2">
                        <label for="stripe_key" class="w-100 mb-2">Stripe Key:</label>
                        @if ($data && $data->stripe_key)
                        <input type="text" name="stripe_key" id="stripe_key" value="{{ $data->stripe_key }}" class="form-control">
                        @else
                        <input type="text" name="stripe_key" id="stripe_key" value="{{ old('stripe_key') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="stripe_secret" class="w-100 mb-2">Stripe Secret:</label>
                        @if ($data && $data->stripe_secret)
                        <input type="text" name="stripe_secret" id="stripe_secret" value="{{ $data->stripe_secret }}" class="form-control">
                        @else
                        <input type="text" name="stripe_secret" id="stripe_secret" value="{{ old('stripe_secret') }}" class="form-control">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card col-md-12">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">SMTP Settings</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="mb-2">
                        <label for="mail_mailer" class="w-100 mb-2">Mail Mailer:</label>
                        @if ($data && $data->mail_mailer)
                        <input type="text" name="mail_mailer" id="mail_mailer" value="{{ $data->mail_mailer }}" class="form-control">
                        @else
                        <input type="text" name="mail_mailer" id="mail_mailer" value="{{ old('mail_mailer') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_host" class="w-100 mb-2">Mail Host:</label>
                        @if ($data && $data->mail_host)
                        <input type="text" name="mail_host" id="mail_host" value="{{ $data->mail_host }}" class="form-control">
                        @else
                        <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_port" class="w-100 mb-2">Mail Port:</label>
                        @if ($data && $data->mail_port)
                        <input type="text" name="mail_port" id="mail_port" value="{{ $data->mail_port }}" class="form-control">
                        @else
                        <input type="text" name="mail_port" id="mail_port" value="{{ old('mail_port') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_username" class="w-100 mb-2">Mail Username:</label>
                        @if ($data && $data->mail_username)
                        <input type="text" name="mail_username" id="mail_username" value="{{ $data->mail_username }}" class="form-control">
                        @else
                        <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_password" class="w-100 mb-2">Mail Password:</label>
                        @if ($data && $data->mail_password)
                        <input type="text" name="mail_password" id="mail_password" value="{{ $data->mail_password }}" class="form-control">
                        @else
                        <input type="text" name="mail_password" id="mail_password" value="{{ old('mail_password') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_encryption" class="w-100 mb-2">Mail Encryption:</label>
                        @if ($data && $data->mail_encryption)
                        <input type="text" name="mail_encryption" id="mail_encryption" value="{{ $data->mail_encryption }}" class="form-control">
                        @else
                        <input type="text" name="mail_encryption" id="mail_encryption" value="{{ old('mail_encryption') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_from_address" class="w-100 mb-2">Mail From Address:</label>
                        @if ($data && $data->mail_from_address)
                        <input type="text" name="mail_from_address" id="mail_from_address" value="{{ $data->mail_from_address }}" class="form-control">
                        @else
                        <input type="text" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="mail_from_name" class="w-100 mb-2">Mail From Name:</label>
                        @if ($data && $data->mail_from_name)
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $data->mail_from_name }}" class="form-control">
                        @else
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name') }}" class="form-control">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card col-md-12">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Guest Checkout</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="form-check form-switch mb-2">
                        @if ($data && $data->guest_checkout)
                        <input class="form-check-input" type="checkbox" id="guest_checkout" name="guest_checkout" 
                            value="{{ $data->guest_checkout }}" 
                            {{ $data->guest_checkout == 1 ? 'checked' : '' }}>
                        @else
                        <input class="form-check-input" type="checkbox" id="guest_checkout" name="guest_checkout" 
                            value="{{ old('guest_checkout') }}" 
                            {{ old('guest_checkout') == 1 ? 'checked' : '' }}>
                        @endif                        
                        <label class="form-check-label ms-3" for="guest_checkout">Guest Checkout</label>
                    </div>                    
                </div>
            </div>
            <div class="card col-md-12">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Commission Setting</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="mb-2">
                        <label for="recaptcha_site_key" class="w-100 mb-2">Commission Rate:</label>
                        @if ($data && $data->default_sales_commission_rate)
                        <input type="text" name="default_sales_commission_rate" id="default_sales_commission_rate" value="{{ $data->default_sales_commission_rate }}" class="form-control">
                        @else
                        <input type="text" name="default_sales_commission_rate" id="default_sales_commission_rate" value="{{ old('default_sales_commission_rate') }}" class="form-control">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card col-md-12">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title mb-0">Recaptcha Settings</h4>
                </div>
                <!-- End Header -->
                <div class="card-body">
                    <div class="mb-2">
                        <label for="recaptcha_site_key" class="w-100 mb-2">Recaptcha Site Key:</label>
                        @if ($data && $data->recaptcha_site_key)
                        <input type="text" name="recaptcha_site_key" id="recaptcha_site_key" value="{{ $data->recaptcha_site_key }}" class="form-control">
                        @else
                        <input type="text" name="recaptcha_site_key" id="recaptcha_site_key" value="{{ old('recaptcha_site_key') }}" class="form-control">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="recaptcha_secret_key" class="w-100 mb-2">Recaptcha Secret Key:</label>
                        @if ($data && $data->recaptcha_secret_key)
                        <input type="text" name="recaptcha_secret_key" id="recaptcha_secret_key" value="{{ $data->recaptcha_secret_key }}" class="form-control">
                        @else
                        <input type="text" name="recaptcha_secret_key" id="recaptcha_secret_key" value="{{ old('recaptcha_secret_key') }}" class="form-control">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card col-md-12">
                <!-- End Header -->
                <div class="card-body">
                    <div class="">
                        <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-3 border border-blue-700 rounded">Save</button>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('js_content')
   <script>
    $(function(){
        $('#guest_checkout').change(function(){
            if($(this).val() == 1){
                $(this).val(0);
            }else{
                $(this).val(1);
            }
        })
    })
   </script>
@endsection
