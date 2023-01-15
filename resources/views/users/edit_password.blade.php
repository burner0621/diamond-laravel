<x-app-layout page-title="Edit Password">
<div class="py-9">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="settings-side-nav">
                            <a class="nav-link w-100 d-block mb-2 {{ $tab == "account" ? "active" : "" }}" href="/user/{{Auth::id()}}?tab=account">Account</a>
                            <a class="nav-link w-100 d-block mb-2 {{ $tab == "security" ? "active" : "" }}" href="{{route('user.update.password')}}">Security</a>
                            <a class="nav-link w-100 d-block {{ $tab == "address" ? "active" : "" }}" href="/user/{{Auth::id()}}?tab=address">Address</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 mr-auto">
                
                @if (session('success'))
                <div class="alert alert-success" role="alert">{{session('success')}}</div>
                @endif
                <form action="{{route('user.update.password')}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="card">
                        <div class="card-header">Change Password</div>
                        <div class="card-body">
                            @include('includes.validation-form')
                            <label for="old_password">Current Password:</label>
                            <input type="password" name="old_password" id="old_password" class="form-control">
                            <br>
                            <label for="new_password">New Password:</label>
                            <input type="password" name="new_password" id="new_password" class="form-control">
                            <br>
                            <label for="new_password_confirmation">Confirm New Password:</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                            <br>
                            <div class="d-block">
                                <button type="submit" class="btn btn-primary">Edit Password</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ route('user.disable') }}" method="post" class="d-inline">
                    @csrf
                    @method('post')
                    <div class="card">
                        <div class="card-header">Deactive Account</div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-outline-danger">
                                Deactive Account
                            </button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
