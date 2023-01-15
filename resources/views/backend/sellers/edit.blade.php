@extends('backend.layouts.app', ['activePage' => 'sellers', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'catalogue'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="card col-md-12">
                            <div class="card-body">
                                @include('includes.validation-form')

                                <form method="POST" action="{{ route('backend.sellers.update', $seller->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6 mb-2">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" value='{{ $seller->name }}' id="name" class="form-control">
                                        </div>

                                        <!-- Email Address -->
                                        <div class="col-md-6 mb-2">
                                            <label for="email">Email:</label>
                                            <input type="text" name="email" value='{{ $seller->email }}' id="email" class="form-control">
                                        </div>

                                    </div>
                                    <div class="row">
                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <x-label for="password" :value="__('Password')" />

                                        <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                             autocomplete="new-password" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-md-6">
                                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                            name="password_confirmation"  />
                                    </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-outline-success">Update seller</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
