<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <div class="pt-4 pb-4 text-center">
            <h1 class="h4 fw-600">
                Create an account
            </h1>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('signup') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="row">
                <div class="col-6">
                    <x-label for="first_name" :value="__('First name')" />
                    <x-input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                        :value="old('first_name')" required autofocus />
                </div>
                <div class="col-6">
                    <x-label for="last_name" :value="__('Last Name')" />
                    <x-input id="last_name" class="block w-full mt-1" type="text" name="last_name" :value="old('last_name')"
                        required autofocus />
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-label for="username" :value="__('Username')" />

                <x-input id="username" class="block w-full mt-1" type="text" name="username" :value="old('username')"
                         required />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block w-full mt-1" type="password"
                    name="password_confirmation" required />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-button class="ml-4 btn-primary">
                    {{ __('Register') }}
                </x-button>
            </div>
            {!! ReCaptcha::htmlScriptTagJsApi([
                'action' => 'homepage',
                'callback_then' => 'callbackThen',
                'callback_catch' => 'callbackCatch',
            ]) !!}
        </form>

        <script type="text/javascript">
            function callbackThen(response) {
                // read HTTP status
                console.log(response.status);

                // read Promise object
                response.json().then(function(data) {
                    console.log(data);
                    if (data.success && data.score > 0.5) {
                        console.log('valid recapcha');
                    } else {
                        document.getElementById('registerForm').addEventListener('submit', function(event) {
                            event.preventDefault();
                        });
                    }
                });
            }

            function callbackCatch(error) {
                console.error('Error:', error)
            }
        </script>
    </x-auth-card>
</x-app-layout>
