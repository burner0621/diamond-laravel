@extends('backend.layouts.app', ['activePage' => 'users', 'title' => 'Edit User', 'navName' => 'Table List', 'activeButton' => 'catalogue'])

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <h1 class="page-header-title">Edit User</h1>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="card col-md-12">
                <div class="card-body">
                    @include('includes.validation-form')

                    <form method="POST" action="{{ route('backend.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- First Name -->
                        <div class="col-md-12 mb-2">
                            <label for="name">First Name:</label>
                            <input type="text" name="first_name" value='{{ $user->first_name }}' id="first_name"
                                class="form-control">
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-12 mb-2">
                            <label for="name">Last Name:</label>
                            <input type="text" name="last_name" value='{{ $user->last_name }}' id="last_name"
                                class="form-control">
                        </div>

                        <!--UserName -->
                        <div class="col-md-12 mb-2">
                            <label for="name">Username:</label>
                            <input type="text" name="username" value='{{ $user->username }}' id="username"
                                class="form-control">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-12 mb-2">
                            <label for="email">Email:</label>
                            <input type="text" name="email" value='{{ $user->email }}' id="email"
                                class="form-control">
                        </div>

                        <!-- Whatsapp -->
                        @if ($user->seller && $user->seller->whatsapp)
                        <div class="col-md-12 mb-2">
                            <label for="whatsapp">Whatsapp:</label>
                            <input type="text"  value='{{ $user->seller->whatsapp }}'
                                class="form-control" disabled>
                        </div>
                        @endif

                        <!-- Status -->
                        <div class="col-md-12 mb-2">
                            <label for="email">Status:</label>
                            <select class="form-control" name="email_verified_at">
                                <option value="1" class="form-control" @if($user->email_verified_at != null) selected @endif> Verified </option>
                                <option value="0" class="form-control" @if($user->email_verified_at == null) selected @endif> Unverified</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="category">Type:</label>
                            <div class="col-md-12">
                                <select class="selectpicker" name="role" data-live-search="true">

                                    <option value="0" @if ($user->role == 0) selected @endif
                                        data-tokens="Customer">Customer</option>
                                    <option value="1" @if ($user->role == 1) selected @endif
                                        data-tokens="Admin">Admin</option>
                                    <option value="3" @if ($user->role == 3) selected @endif
                                        data-tokens="Seller">Seller</option>


                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-lg btn-primary">Update user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
