<x-app-layout page-title="My Informations">
    <div class="container">
        <div class="row">
            <div class="w-20 py-9">
                <nav class="navbar bg-light navbar-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ $tab == "account" ? "active" : "" }}" href="/user/{{$user->id}}?tab=account">Account</a>
                            </li>
                            @can('edit', $user)
                            <li class="nav-item">
                                <a class="nav-link {{ $tab == "security" ? "active" : "" }}" href="{{ route('user.edit.password') }}">Security</a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link {{ $tab == "address" ? "active" : "" }}" href="/user/{{$user->id}}?tab=address">Address</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 py-9 mx-auto">
                @if (session('message'))
                    <div class="row justify-content-center">
                        <div class="card col-md-6 mb-3">
                            <div class="card-body text-success text-center">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif
                <x-user-info-main :user="$user" :shipping="$shipping" :billing="$billing" :edit='false' :tab="$tab" />

                @can('edit', $user)
                <div class="card">
                    <div class="card-body">
                        @if ($tab == "security")
                        <a href="{{ route('user.edit.password') }}" class="btn btn-outline-dark">Change My Password</a>
                        <form action="{{ route('user.delete') }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger">
                                Delete Account
                            </button>
                        </form>
                        @else
                        <a href="/user/edit?tab={{ $tab }}" class="btn btn-outline-success">Edit my informations</a>
                        @endif
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
